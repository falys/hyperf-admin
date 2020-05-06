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

use App\Annotations\Validation;
use App\Lib\JwtToken;
use App\Lib\Utils;
use App\Model\Service\UserService;
use Hyperf\Di\Annotation\Inject;

class AuthController extends AbstractController
{

    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * @Inject()
     * @var Utils
     */
    private $utils;

    /**
     * @Inject()
     * @var JwtToken
     */
    private $jwt;


    /**
     * @Validation(mode="User",scene="login")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        $data   = $this->request->all();
        $result = $this->userService->login($data);
        if($result === false) {
            return $this->error($this->userService->getErrMessage());
        }
        return $this->json($result);
    }

    public function refreshToken() {
        $token  = $this->utils->getToken($this->request);
        $result = $this->userService->refreshToken($token);
        if($result === false) {
            return $this->error($this->userService->getErrMessage());
        }
        return $this->json($result);
    }

    public function logout() {
        $token  = $this->utils->getToken($this->request);
        $this->userService->logout($token);
        return $this->success();
    }

    public function getMenus() {
        $token  = $this->utils->getToken($this->request);
        $userid = $this->jwt -> getUidByToken($token);
        $result = $this->userService->getNav($userid);
        return $this->json($result);
    }

    public function getButtons() {
        $token  = $this->utils->getToken($this->request);
        $userid = $this->jwt -> getUidByToken($token);
        $result = $this->userService->getButtons($userid);
        return $this->json($result);
    }
}
