<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Entities\Product;

class ProductController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $ProductRepository;

    public function __construct()
    {
        $this->ProductRepository = app(ProductRepository::class);
    }

    //table name
    public $table = 'product';

    /**
     * product list
     * @return string
     */
    public function list(): string
    {
        $products = $this->ProductRepository
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['id', 'name', 'sku', 'image', 'created_at'])
            ->toArray();
        $productList = &$products['data'];

        foreach ($productList as &$value) {
            $value->created_at = date('Y-m-d H:i:s', $value->created_at);
            $value->image = $this->getDomain() . $value->image;
        }

        return view('admin.product.index', compact('products'));
    }

    /**
     * add product
     * @param ProductRequest $request
     * @return string
     */
    public function create(ProductRequest $request): string
    {
        $name = $request->post('name');
        do {
            $sku = $this->randStr();
            $exists = $this->ProductRepository->where('sku', $sku)->exists();
        } while ($exists);
        $image = $request->post('image');

        $res = $this->ProductRepository->create([
            'name' => $name,
            'sku' => $sku,
            'image' => $image,
            'created_at' => time()
        ]);

        return view('admin.login.index', compact('res'));
    }

    /**
     * product detail
     * @param ProductRequest $request
     * @return string
     */
    public function details(ProductRequest $request): string
    {
        $id = $request->input('id');

        $data = $this->ProductRepository->where('id', $id)->first(['id', 'name', 'sku', 'image', 'created_at', 'updated_at']);
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
     * @param Product $product
     * @return string
     */
    public function edit(Product $product): string
    {
        return view('admin.product.edit', compact('product'));
    }

    /**
     * del product
     * @param ProductRequest $request
     * @return string
     */
    public function delete(ProductRequest $request): string
    {
        $id = $request->input('id');

        $res = $this->ProductRepository->delete($id);

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
