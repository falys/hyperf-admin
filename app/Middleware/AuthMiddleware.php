<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Lib\JwtToken;
use App\Lib\Utils;
use App\Model\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var redis
     */
    protected $redis;

    /**
     * @var Utils|mixed
     */
    protected $utils;

    /**
     * @var UserService|mixed
     */
    protected $userService;

    protected $ignore;

    /**
     * @Inject()
     * @var \Hyperf\HttpServer\Contract\ResponseInterface
     */
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container   = $container;
        $this->jwt         = $container->get(JwtToken::class);
        $this->redis       = $container->get(Redis::class);
        $this->utils       = $container->get(Utils::class);
        $this->userService = $container->get(UserService::class);
        $this->ignore      = config('whitelist'); //权限白名单
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->utils->getToken($request);
        if(!$this->jwt->validateToken($token)){
            return $this->response->json(['code'=>-100,'message'=>'登录已过期,请重新登录','data'=>(object)[]]);
        }
        $uri  = $request->getUri()->getPath();
        $uri  = str_replace('/admin','',$uri);
        if(!in_array($uri, $this->ignore)) {
            $userid = $this->jwt->getUidByToken($token);
            $isPermission  = $this->userService->isPermission($uri); //是否是权限URI
            $hasPermission = $this->userService->hasPermission($userid, $uri);//判断是否有操作权限
            if($isPermission && !$hasPermission){
                return $this->response->json(['code'=>403,'message'=>'无操作权限','data'=>(object)[]]);
            }
        }
        return $handler->handle($request);
    }
}