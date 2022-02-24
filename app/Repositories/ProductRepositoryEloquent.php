<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Entities\Product;
use App\Validators\ProductValidator;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Product[]
     */
    public function findAll()
    {
        $products = App\Product::all();
        foreach ($products as &$value) {
            $value->created_at = date('Y-m-d H:i:s', $value->created_at);
            $value->image = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $value->image;
        }
        return $products;
    }

    /**
     *
     * find detail
     * @return mixed
     */
    public function findOne($id)
    {
        return App\Product::find($id);
    }

    /**
     *
     * delete one
     * @return mixed
     */
    public function deleteOne($id)
    {
        return App\Product::where('id', $id)->delete();
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
