<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/27/20
 * Time: 10:09 AM
 */
return [
    # 非对称加密使用字符串,请使用自己加密的字符串
    'secret' => env('JWT_SECRET', 'jwthyperf'),

    # token过期时间，单位为秒
    'ttl' => env('JWT_TTL', 7200),

    # jwt的hearder加密算法  目前仅支持对称加密
    'alg' => env('JWT_ALG', 'HS256'),
];