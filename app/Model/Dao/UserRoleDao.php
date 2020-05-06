<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/30/20
 * Time: 9:57 PM
 */

namespace App\Model\Dao;


use App\Model\Entity\SystemRolesUser;
use Hyperf\DbConnection\Db;

class UserRoleDao
{
    /**
     * 添加用户角色
     * @param $data
     * @return bool
     */
    public function create($data) {
        $userRole = new SystemRolesUser();
        $userRole->user_id        = $data['userid'];
        $userRole->system_role_id = $data['roleid'];
        return $userRole->save();
    }

    /**
     * 删除角色成员
     * @param $data
     * @return bool
     */
    public function delete($data) {
        return SystemRolesUser::query()->where(['user_id'=>$data['userid'],'system_role_id'=>$data['roleid']])->delete();
    }

    /**
     * 获取用户角色
     * @param array $data
     * @return mixed
     */
    public function getUserRole(array $data) {
        return SystemRolesUser::where(['user_id'=>$data['userid'],'system_role_id'=>$data['roleid']])->first();
    }

    /**
     * 角色成员列表
     * @param int $roleid
     * @return mixed
     */
    public function getRoleUserList(string $roleid) {
        return Db::table('system_roles_user')
            ->join('user', 'user.id', '=', 'system_roles_user.user_id')
            ->select('system_roles_user.*','user.mobile','user.username')
            ->where('system_role_id',$roleid)
            ->get();
    }
}