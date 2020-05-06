<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/25/20
 * Time: 3:38 PM
 */

namespace App\Model\Service;


use App\Model\Dao\PermissionDao;
use App\Model\Dao\RolePermissionDao;
use Hyperf\Di\Annotation\Inject;

class PermissionService
{
    /**
     * @Inject()
     * @var PermissionDao
     */
    private $permission;


    /**
     * @Inject()
     * @var RolePermissionDao
     */
    private $rolePermissionDao;


    private $errMessage;

    /**
     * 用户登录
     * @param array $data
     * @return array|bool
     */
    public function getTreeList() {
        $result = [];
        $result = $this->_getPermisionLoop();
        return $result;
    }


    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public function create(array $data) {
        return $this->permission->create($data);
    }

    /**
     * 修改
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        return $this->permission->update($data);
    }

    /**
     * 删除
     * @param integer $permissionId
     * @return int
     */
    public function delete(int $permissionId) {
        return $this->permission->delete($permissionId);
    }

    /**
     * 权限分配
     * @param array $data
     * @return bool
     */
    public function permissionAssign(array $data) {
        return $this->rolePermissionDao->assignPermission($data);
    }

    private function _getPermisionLoop(int $pid=0) {
        $i = 0;
        $list = [];
        $menuList = $this->permission->getlist($pid);
        foreach ($menuList as $key => $val)
        {
            $list[$i]['permissionId'] = $val['permissionId'];
            $list[$i]['parentId']     = $val['parentId'];
            $list[$i]['name']         = $val['name'];
            $list[$i]['displayName']  = $val['displayName'];
            $list[$i]['effectUri']    = $val['effectUri'];
            $list[$i]['description']  = $val['description'];
            $list[$i]['isNav']        = $val['isNav'];
            $list[$i]['navDec']       = $val['isNav']==1 ? "导航菜单" : '按钮';
            $list[$i]['icon']         = $val['icon'];
            $list[$i]['order']        = $val['order'];
            $children = $this->_getPermisionLoop($val['permissionId']);
            if($children) {
                $list[$i]['children'] = $children;
            }
            $i++;
        }
        return $list;
    }

    public function getErrMessage(){
        return $this->errMessage;
    }
}