<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/27/20
 * Time: 10:06 AM
 */

namespace App\Lib;


use Firebase\JWT\JWT;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

class JwtToken
{

    /**
     * @Inject()
     * @var Redis
     */
    private $redis;
    /**
     * 生成token
     * @param string $userId
     * @return string
     */
    public function createToken(string $userId, $iat) {
        $secret = config('jwt.secret');
        $ttl    = config('jwt.ttl');
        $payload = array(
            "iss" => "Api",
            "aud" => $userId,
            "iat" => $iat,
            "nbf" => $iat,
            "exp" => $iat + $ttl
        );
        $token = JWT::encode($payload, $secret);
        $this->redis->set("JWT_".$userId, $token, $ttl); //存入redis
        return $token;
    }

    /**
     * 刷新token
     * @param string $token
     * @return array|bool
     */
    public function refreshToken(string $token) {
        $secret  = config('jwt.secret');
        $alg     = config('jwt.alg');
        try {
            $decoded = JWT::decode($token, $secret, [$alg]);
            if ($decoded) {
                $userid = $decoded->aud;
                $token = $this->createToken($userid,time());
                return ['userid' => $userid, 'token' => $token];
            }
        } catch (\Exception $e){
            return false;
        }
        return false;
    }

    /**
     * 根据token获取userid
     * @param string $token
     * @return mixed
     * @throws \Exception
     */
    public function getUidByToken(string $token) {
        $secret  = config('jwt.secret');
        $alg     = config('jwt.alg');
        try {
            $decoded = JWT::decode($token, $secret, [$alg]);
            if($decoded) {
                return $decoded->aud;
            }
        } catch (\Exception $e){
            throw new \Exception();
        }
    }

    /**
     * 校验token
     * @param string $token
     * @return bool
     */
    public function validateToken(string $token) {
        $secret  = config('jwt.secret');
        $alg     = config('jwt.alg');

        try{
            $decoded = JWT::decode($token, $secret, array($alg));
            if($decoded) {
                $cacheToken = $this->redis->get('JWT_'.$decoded->aud);
                if($token == $cacheToken) {
                    return true;
                }
            }
        }catch (\Exception $e){
            return false;
        }
        return false;
    }


}