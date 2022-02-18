<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //table name
    public $table = 'product';

    /**
     * product list
     * @return string
     */
    public function list(): string
    {
        $data = $this->db()->orderBy('created_at', 'desc')
            ->paginate(10, ['id', 'name', 'sku', 'image', 'created_at'])
            ->toArray();
        $productList = &$data['data'];

        foreach ($productList as &$value) {
            $value->created_at = date('Y-m-d H:i:s', $value->created_at);
            $value->image = $this->getDomain() . $value->image;
        }

        return $this->json([
            'code' => 200,
            'msg' => 'products',
            'data' => $data
        ]);
    }

    /**
     * add product
     * @param Request $request
     * @return string
     */
    public function create(Request $request): string
    {
        $db = $this->db();
        $name = $request->post('name');
        $sku = "";
        do {
            $sku = $this->randStr();
            $exists = $db->where('sku', $sku)->exists();
        } while ($exists);
        $image = $request->post('image');

        $res = $db->insert([
            'name' => $name,
            'sku' => $sku,
            'image' => $image,
            'created_at' => time()
        ]);
        if ($res) {
            return $this->json([
                'code' => 200,
                'msg' => 'add success',
                'data' => []
            ]);
        }
        return $this->json([
            'code' => 400,
            'msg' => 'add fail',
            'data' => []
        ]);
    }

    /**
     * product detail
     * @param Request $request
     * @return string
     */
    public function details(Request $request): string
    {
        $id = $request->input('id');

        $data = $this->db()->where('id', $id)->first(['id', 'name', 'sku', 'image', 'created_at', 'updated_at']);
        $data->created_at = date('Y-m-d H:i:s', $data->created_at);
        $data->updated_at = $data->updated_at ? date('Y-m-d H:i:s', $data->updated_at) : null;
        $data->image = $this->getDomain() . $data->image;

        return $this->json([
            'code' => 200,
            'msg' => 'product detail',
            'data' => $data
        ]);
    }

    /**
     * product edit
     * @param Request $request
     * @return string
     */
    public function edit(Request $request): string
    {
        $id = $request->input('id');
        $image = $request->input('image');
        $name = $request->input('name');
        $imageDomain = explode($this->getDomain(), $image);
        $imageDomainCount = count($imageDomain);
        if ($imageDomainCount > 1) {
            $image = $imageDomain[$imageDomainCount - 1];
        }

        $res = $this->db()->where('id', $id)->update([
            'image' => $image,
            'name' => $name,
            'updated_at' => time()
        ]);
        if ($res) {
            return $this->json([
                'code' => 200,
                'msg' => 'edit success',
                'data' => []
            ]);
        }
        return $this->json([
            'code' => 400,
            'msg' => 'edit fail',
            'data' => []
        ]);
    }

    /**
     * del product
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
}
