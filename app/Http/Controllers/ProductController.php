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
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->$productRepository = $productRepository;
    }


    /**
     * product list
     * @return string
     */
    public function list(): string
    {
        $products = $this->ProductRepository->findAll();

        return view('admin.product.index', compact('products'));
    }

    /**
     * add product
     * @param ProductRequest $request
     * @return string
     */
    public function create(ProductRequest $request): string
    {
        return view('admin.product.index');
    }

    /**
     * product detail
     * @param ProductRequest $request
     * @return string
     */
    public function details(ProductRequest $request): string
    {
        $id = $request->input('id');

        $detail = $this->ProductRepository->findOne($id);

        return view('admin.login.index', compact('detail'));
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

        $res = $this->ProductRepository->deleteOne($id);

        return view('admin.product.index', compact('res'));
    }
}
