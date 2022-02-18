<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 获取db
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function db(): \Illuminate\Database\Query\Builder
    {
        return DB::table($this->table);
    }

    /**
     * 将指定的数据转换为json
     *
     * @param  mixed $data
     *
     * @return string
     */
    public function json($data): string
    {
        return json_encode($data);
    }

    /**
     * 生成随机字符串
     *
     * @param  int $len 指定长度
     *
     * @return string
     */
    public function randStr(int $length = 12): string
    {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str) - 1;

        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num      = mt_rand(0, $len);
            $randstr .= $str[$num];
        }

        return $randstr;
    }

    /**
     * 获取当前域名
     *
     * @return string
     */
    public function getDomain()
    {
        $server = $_SERVER;

        return $server['REQUEST_SCHEME'] . '://' . $server['HTTP_HOST'];
    }
}
