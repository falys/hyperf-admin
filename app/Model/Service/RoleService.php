<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/30/20
 * Time: 4:45 PM
 */

namespace App\Model\Service;


use App\Model\Dao\RoleDao;
use App\Model\Dao\RolePermissionDao;
use App\Model\Dao\UserRoleDao;
use Hyperf\Di\Annotation\Inject;

class RoleService
{

    /**
     * @Inject()
     * @var RoleDao
     */
    private $roleDao;

    /**
     * @Inject()
     * @var UserRoleDao
     */
    private $userRoleDao;

    /**
     * @Inject()
     * @var RolePermissionDao
     */
    private $rolePermissionDao;

    /**
     * @var 错误信息
     */
    private $errMessage;

    public function getList(array $data) {
        return $this->roleDao->getRoleList($data['page'],$data['pageSize']);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public function create(array $data) {
        return $this->roleDao->create($data);
    }

    /**
     * 修改
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        return $this->roleDao->update($data);
    }

    /**
     * 删除
     * @param integer $userid
     * @return int
     */
    public function delete(int $roleId) {
        return $this->roleDao->delete($roleId);
    }

    /**
     * 获取角色成员列表
     * @param string $roleId
     * @return array
     */
    public function getRoleMemberList(string $roleId) {
        $data   = [];
        $result = $this->userRoleDao->getRoleUserList($roleId);
        foreach ($result as $item) {
            $temp = [];
            $temp['roleid']   = $item->system_role_id;
            $temp['userid']   = $item->user_id;
            $temp['username'] = $item->username;
            $temp['mobile']   = $item->mobile;
            array_push($data, $temp);
        }
        return $data;
    }

    /**
     * 用户赋予角色
     * @param array $data
     * @return bool
     */
    public function memberAdd(array $data) {
        if($this->userRoleDao->getUserRole($data)) {
            $this->errMessage = "该角色中已有此用户";
            return false;
        }
        return $this->userRoleDao->create($data);
    }

    /**
     * 删除角色成员
     */
    public function memberDelete(array $data) {
        return $this->userRoleDao->delete($data);
    }

    /**
     * 获取角色选择列表
     *
     * @return array
     */
    public function rolesOption() {
        return $this->roleDao->getOptions();
    }
    

    /**
     * 获取权限角色
     * @param int $roleId
     * @return \Hyperf\Utils\Collection
     */
    public function getRolePermissions(int $roleId){
        return $this->rolePermissionDao->getRolePermissionsByRoleId($roleId);
    }

    /**
     * 为角色分配权限
     * @param array $data
     * @return bool
     */
    public function assignPermission(array $data) {
        return $this->rolePermissionDao->assignPermission($data);
    }

    public function getErrMessage(){
        return $this->errMessage;
    }
}