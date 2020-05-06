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
use App\Model\Service\PermissionService;
use Hyperf\Di\Annotation\Inject;

class PermissionController extends AbstractController
{


    /**
     * @Inject()
     * @var PermissionService
     */
    private $permissionService;


    public function list()
    {
        $result = $this->permissionService->getTreeList();
        return $this->json($result);
    }

    /**
     * @Validation(mode="permission",scene="create")
     */
    public function create() {
        $data   = $this->request->all();
        $result = $this->permissionService->create($data);
        if($result === false) {
           return $this->error("创建失败");
        }
        return $this->success();
    }

    /**
     * @Validation(mode="permission",scene="update")
     */
    public function update() {
        $data   = $this->request->all();
        $result = $this->permissionService->update($data);
        if($result === false) {
            return $this->error("修改失败");
        }
        return $this->success();
    }

    /**
     * @Validation(mode="permission",scene="delete")
     */
    public function delete() {
        $permissionId = $this->request->input('permissionId');
        $result       = $this->permissionService->delete($permissionId);
        if($result === false) {
            return $this->error("删除失败");
        }
        return $this->success();
    }

    public function permissionAssign() {
        $data = $this->request->all();
        $result = $this->permissionService->permissionAssign($data);
        if($result === false) {
            return $this->error("分配失败");
        }
        return $this->success();

    }
}
