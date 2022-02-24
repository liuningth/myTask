<?php

namespace App\Http\Controllers;

use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Message;
use Illuminate\Database\Query\Builder;
use App\Http\Requests\CouponRequest;

class CouponController extends Controller
{

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected CouponRepository $couponRepository;
    protected ProductRepository $productRepository;

    public function __construct(CouponRepository $couponRepository, ProductRepository $productRepository)
    {
        $this->$couponRepository = $couponRepository;
        $this->$productRepository = $productRepository;
    }
    /**
     * coupon list
     * @return string
     */
    public function list(): string
    {
        $coupon = $this->couponRepository->findAll();

        return view('admin.coupons.index', compact('coupon'));
    }

    /**
     * product list
     * @return string
     */
    public function productList(): string
    {
        $products = $this->couponRepository->findAll();

        return view('admin.coupons.index', compact('products'));
    }

    /**
     * create coupon
     * @param CouponRequest $request
     * @return string
     */
    public function create(CouponRequest $request): string
    {
        $status = $this->couponRepository->create();

        return view('admin.coupons.add', compact('status'));
    }

    /**
     * coupon detail
     * @param Request $request
     * @return string
     */
    public function details(CouponRequest $request): string
    {
        $id = $request->input('id');
        $detail = $this->couponRepository->findOne($id);

        return view('admin.coupons.edit', compact('detail'));
    }

    /**
     * edit coupon
     * @param Request $request
     * @return string
     */
    public function edit(CouponRequest $request): string
    {
        $id = $request->input('id');
        $coupon = $this->couponRepository->findOne($id);

        $status = $this->couponRepository->updateCoupon($request, $coupon);

        return view('admin.coupons.index', compact('status'));

    }

    /**
     * del coupon
     * @param Request $request
     * @return string
     */
    public function delete(CouponRequest $request): string
    {
        $id = $request->input('id');

        $res = $this->couponRepository->deleteOne($id);

        return view('admin.coupon.index', compact('res'));
    }

}
