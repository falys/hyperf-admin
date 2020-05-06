<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/27/20
 * Time: 4:35 PM
 */

namespace App\Lib;


class Utils
{
    /**
     * 获取token
     * @param $request
     * @return string
     */
    public function getToken($request) {
        $token  = '';
        $header = $request->getHeaderLine('authorization');
        $regexp = "/Token\s+(.*)$/i";
        if (preg_match($regexp, $header, $matches)) {
            $token = $matches[1];
        }
        return $token;
    }

    /**
     * 随机数
     * @param int $len
     * @return string
     */
    public function randString($len = 4)
    {
        $chars = '1234567890abcdefghigklmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < $len; $i++) {
            $rand = rand(0, strlen($chars)-1);
            $string .= substr($chars, $rand, 1);
        }
        return $string;
    }
}