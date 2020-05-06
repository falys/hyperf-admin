<?php

declare(strict_types=1);

namespace App\Controller;

use App\Annotations\Validation;
use App\Model\Service\UserService;
use Hyperf\Di\Annotation\Inject;

class UserController extends AbstractController
{
    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * @Validation(mode="User",scene="list")
     */
    public function list()
    {
        $param  = $this->request->all();
        $result = $this->userService->getList($param);
        return $this->json($result);
    }

    /**
     * @Validation(mode="User",scene="create")
     */
    public function create() {
        $data = $this->request->all();
        $ret  = $this->userService->create($data);
        if($ret === false) {
            return $this->error('添加失败');
        }
        return $this->success();
    }

    /**
     * @Validation(mode="User",scene="update")
     */
    public function update() {
        $data = $this->request->all();
        $ret  = $this->userService->update($data);
        if($ret === false) {
            return $this->error('添加失败');
        }
        return $this->success();
    }

    /**
     * @Validation(mode="User",scene="delete")
     */
    public function delete() {
        $userid = $this->request->input('userid');
        $ret = $this->userService->delete($userid);
        if($ret === false) {
            return $this->error('删除失败');
        }
        return $this->success();
    }

    public function userSearch() {
        $param  = $this->request->input('mobile');
        $result = $this->userService->userSearch($param);
        return $this->json($result);
    }

}
