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
use App\Model\Service\RoleService;
use function GuzzleHttp\Promise\all;
use Hyperf\Di\Annotation\Inject;

class RoleController extends AbstractController
{

    /**
     * @Inject()
     * @var RoleService
     */
    private $roleService;

    /**
     * @Validation(mode="Role",scene="list")
     */
    public function list()
    {
        $data   = $this->request->all();
        $result = $this->roleService->getList($data);
        return $this->json($result);
    }

    /**
     * @Validation(mode="Role",scene="create")
     */
    public function create() {
        $data = $this->request->all();
        $result = $this->roleService->create($data);
        if($result === false) {
            return $this->error("创建失败");
        }
        return $this->success();
    }

    /**
     * @Validation(mode="Role",scene="update")
     */
    public function update() {

        $data   = $this->request->all();
        $result = $this->roleService->update($data);
        if($result === false) {
            return $this->error("修改失败");
        }
        return $this->success();

    }

    /**
     * @Validation(mode="Role",scene="delete")
     */
    public function delete() {
        $roleId = $this->request->input('roleId');
        $result = $this->roleService->delete($roleId);
        if($result === false) {
            return $this->error("删除失败");
        }
        return $this->success();
    }

    public function getRolesOptions() {
        $result = $this->roleService->rolesOption();
        return $this->json($result);
    }

    public function rolePermissions() {
        $roleId = $this->request->input('roleId');
        $result = $this->roleService->getRolePermissions($roleId);
        return $this->json($result);
    }

    public function roleMemberList() {
        $roleId = $this->request->input('roleid');
        $result = $this->roleService->getRoleMemberList($roleId);
        return $this->json($result);
    }

    public function roleMemberAdd(){
        $data = $this->request->all();
        $result = $this->roleService->memberAdd($data);
        if($result === false) {
            return $this->error($this->roleService->getErrMessage());
        }
        return $this->success();
    }

    public function roleMemberDelete(){
        $data = $this->request->all();
        $result = $this->roleService->memberDelete($data);
        if($result === false) {
            return $this->error($this->roleService->getErrMessage());
        }
        return $this->success();
    }


    public function assignPermission() {
        $data = $this->request->all();
        $result = $this->roleService->assignPermission($data);
        if($result === false) {
            return $this->error($this->roleService->getErrMessage());
        }
        return $this->success();
    }

    public function addUser(){
        $data = $this->request->all();
        $result = $this->roleService->addUser($data);
        if($result === false) {
            return $this->error($this->roleService->getErrMessage());
        }
        return $this->success();
    }
}
