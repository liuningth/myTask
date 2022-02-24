<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CouponRepository;
use App\Entities\Coupon;
use App\Validators\CouponValidator;

/**
 * Class CouponRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CouponRepositoryEloquent extends BaseRepository implements CouponRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Coupon::class;
    }

    public function findAll()
    {
        $data = App\Coupon::orderBy('c.created_at', 'desc')
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

        return $productList;
    }

    public function creat($request)
    {
        $time = time();
        $money = $request->post('money');
        $startTime = $request->post('start_time');
        $endTime = $request->post('end_time');
        $products = (array)$request->post('products');
        $adminId = $request->post('admin_id');

        DB::beginTransaction();
        try {
            $res = App\Coupon::insertGetId([
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
                    $message->to('1103215644@qq.com');
                    $message->subject('The administrator created a new coupon');
                });
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            DB::rollBack();
        }
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

    /**
     *
     * find one data
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $data = App\Coupon::where('id', $id)
            ->first(['id', 'money', 'start_time', 'end_time', 'created_at', 'updated_at']);
        $data->start_time = date('Y-m-d H:i:s', $data->start_time);
        $data->end_time = date('Y-m-d H:i:s', $data->end_time);
        $data->created_at = date('Y-m-d H:i:s', $data->created_at);
        $data->updated_at = $data->updated_at ? date('Y-m-d H:i:s', $data->updated_at) : null;
        $data->products = DB::table('product_coupon', 'pc')
            ->join('product as p', 'pc.product_id', 'p.id')
            ->where('pc.coupon_id', $data->id)
            ->pluck('p.id');

        return $data;
    }

    /**
     *
     * @param $request
     * @param $coupon
     * @return mixed|void
     */
    public function updateCoupon($request, $coupon)
    {
        $time = time();
        $id = $coupon->id;
        $products = $coupon->products;

        DB::beginTransaction();
        try {
            if ($coupon) {
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
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            DB::rollBack();
        }
    }

    /**
     *
     *
     * @param $id
     * @return mixed|void
     */
    public function deleteOne($id)
    {
        return App\Coupon::where('id', $id)->delete();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
