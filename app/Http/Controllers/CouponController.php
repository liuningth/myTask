<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Message;
use Illuminate\Database\Query\Builder;

class CouponController extends Controller
{
    //table name
    public $table = 'coupon';

    /**
     * coupon list
     * @return string
     */
    public function list(): string
    {
        $this->table = $this->table . ' as c';

        $data = $this->db()->orderBy('c.created_at', 'desc')
            ->select(['c.id', 'c.money', 'c.start_time', 'c.end_time', 'c.created_at'])
            ->selectSub(function (Builder $builder) {
                $builder->from('product_coupon', 'pc')
                    ->join('product as p', 'pc.product_id', 'p.id')
                    ->whereColumn('pc.coupon_id', 'c.id')
                    ->selectRaw('GROUP_CONCAT(p.name)');
            }, 'products')
            ->paginate(10)
            ->toArray();
        $productList = &$data['data'];

        foreach ($productList as $value) {
            $value->created_at = date('Y-m-d H:i:s', $value->created_at);
            $value->start_time = date('Y-m-d H:i:s', $value->start_time);
            $value->end_time = date('Y-m-d H:i:s', $value->end_time);
        }

        return $this->json([
            'code' => 200,
            'msg' => 'coupon',
            'data' => $data
        ]);
    }

    /**
     * product list
     * @return string
     */
    public function productList(): string
    {
        $data = DB::table('product')
            ->get(['id', 'name']);

        return $this->json([
            'code' => 200,
            'msg' => 'product list',
            'data' => $data
        ]);
    }

    /**
     * create coupon
     * @param Request $request
     * @return string
     */
    public function create(Request $request): string
    {
        $time = time();
        $money = $request->post('money');
        $startTime = $request->post('start_time');
        $endTime = $request->post('end_time');
        $products = (array)$request->post('products');
        $adminId = $request->post('admin_id');
        if (empty($adminId)) {
            return $this->json([
                'code' => 400,
                'msg' => 'please login',
                'data' => []
            ]);
        }

        DB::beginTransaction();
        try {
            $res = $this->db()->insertGetId([
                'money' => $money,
                'start_time' => strtotime($startTime),
                'end_time' => strtotime($endTime),
                'created_at' => $time
            ]);
            if ($res) {
                $productData = [];
                foreach ($products as $v) {
                    $productData[] = [
                        'product_id' => $v,
                        'coupon_id' => $res,
                        'created_at' => $time
                    ];
                }
                $this->addProductCoupon($res, $productData);
                DB::commit();
                $adminName = DB::table('admin_user')->where('id', $adminId)->value('name');
                $text = 'administrators:' . $adminName . 'created a coupon with an amount of ' . $money . ' yuan,'
                    . 'start time：' . $startTime
                    . ',end time：' . $endTime;
                Mail::raw($text, function (Message $message) {
                    //e-mail address
                    //1103215644@qq.com
                    $message->to('1103215644@qq.com');
                    //Mail subject
                    $message->subject('The administrator created a new coupon');
                });
                return $this->json([
                    'code' => 200,
                    'msg' => 'create success',
                    'data' => []
                ]);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            DB::rollBack();
        }
        return $this->json([
            'code' => 400,
            'msg' => 'create fail',
            'data' => []
        ]);
    }

    /**
     * coupon detail
     * @param Request $request
     * @return string
     */
    public function details(Request $request): string
    {
        $id = $request->input('id');

        $data = $this->db()->where('id', $id)
            ->first(['id', 'money', 'start_time', 'end_time', 'created_at', 'updated_at']);
        $data->start_time = date('Y-m-d H:i:s', $data->start_time);
        $data->end_time = date('Y-m-d H:i:s', $data->end_time);
        $data->created_at = date('Y-m-d H:i:s', $data->created_at);
        $data->updated_at = $data->updated_at ? date('Y-m-d H:i:s', $data->updated_at) : null;
        $data->products = DB::table('product_coupon', 'pc')
            ->join('product as p', 'pc.product_id', 'p.id')
            ->where('pc.coupon_id', $data->id)
            ->pluck('p.id');

        return $this->json([
            'code' => 200,
            'msg' => 'coupon detail',
            'data' => $data
        ]);
    }

    /**
     * edit coupon
     * @param Request $request
     * @return string
     */
    public function edit(Request $request): string
    {
        $time = time();
        $id = $request->input('id');
        $money = $request->post('money');
        $startTime = strtotime($request->post('start_time'));
        $endTime = strtotime($request->post('end_time'));
        $products = $request->post('products');

        DB::beginTransaction();
        try {
            $res = $this->db()->where('id', $id)->update([
                'money' => $money,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'updated_at' => $time
            ]);
            if ($res) {
                $productData = [];
                foreach ($products as $v) {
                    $productData[] = [
                        'product_id' => $v,
                        'coupon_id' => $id,
                        'created_at' => $time
                    ];
                }
                $this->addProductCoupon($id, $productData);
                DB::commit();
                return $this->json([
                    'code' => 200,
                    'msg' => '编辑成功',
                    'data' => []
                ]);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            DB::rollBack();
        }
        return $this->json([
            'code' => 400,
            'msg' => 'edit fail',
            'data' => []
        ]);
    }

    /**
     * del coupon
     * @param Request $request
     * @return string
     */
    public function delete(Request $request): string
    {
        $id = $request->input('id');

        $res = $this->db()->delete($id);

        if ($res) {
            return $this->json([
                'code' => 200,
                'msg' => 'del success',
                'data' => []
            ]);
        }
        return $this->json([
            'code' => 400,
            'msg' => 'del fail',
            'data' => []
        ]);
    }

    /**
     * add product coupon
     * @param int $couponId
     * @param array $data product and coupon mapping
     * @return bool
     */
    public function addProductCoupon(int $couponId, array $data): bool
    {
        DB::table('product_coupon')->where('coupon_id', $couponId)->delete();

        return DB::table('product_coupon')->insert($data);
    }
}
