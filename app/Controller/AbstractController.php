<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    public function json($data = [], $msg = '', $code = 0)
    {
        return [
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ];
    }


    public function success($data = [], $msg = '操作成功', $code = 0)
    {
        return [
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ];
    }


    public function error($msg = '', $data = [], $code = -1)
    {
        return [
            'status' => $code,
            'message' => $msg,
            'data' => $data
        ];
    }

    public function getToken() {

        $token  = '';
        $header = $this->request->getHeaderLine('authorization');
        $regexp = "/Token\s+(.*)$/i";
        if (preg_match($regexp, $header, $matches)) {
            $token = $matches[1];
        }
        return $token;
    }
}
