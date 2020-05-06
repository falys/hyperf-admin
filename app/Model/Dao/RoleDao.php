<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/30/20
 * Time: 4:46 PM
 */

namespace App\Model\Dao;


use App\Model\Entity\SystemRole;
use Hyperf\DbConnection\Db;

class RoleDao
{
    /**
     * 角色列表
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getRoleList(int $page=1, int $pageSize = 10) {
        $list  = [];
        $data  = [];
        $total  = Db::table('system_roles')->count();
        $result = Db::table('system_roles')->offset(($page-1)*$pageSize)->limit($pageSize)->get();
        foreach ($result as $item) {
            $temp = [];
            $temp['roleId']      = $item->id;
            $temp['name']        = $item->name;
            $temp['displayName'] = $item->display_name;
            $temp['description'] = $item->description;
            array_push($list, $temp);
        }
        $data['list']  = $list;
        $data['total'] = $total;
        return $data;
    }

    /**
     * 添加角色
     * @param array $data
     * @return bool
     */
    public function create(array $data) {
        $role = new SystemRole();
        $role->name         = $data['name'];
        $role->display_name = $data['displayName'];
        $role->description  = $data['description'];
        if($role->save()) {
            return true;
        }
        return false;
    }

    /**
     * 修改角色
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        $user = SystemRole::query()->where('id', $data['roleId'])->first();
        if(isset($data['name'])) {
            $user->name = $data['name'];
        }
        if(isset($data['displayName']) ) {
            $user->display_name = $data['displayName'];
        }
        if(isset($data['description'])) {
            $user->description  = $data['description'];
        }

        if($user->save()) {
            return true;
        }
        return false;
    }

    /**
     * 删除删除角色
     * @param string $userid
     * @return int
     */
    public function delete(string $roleId) {
        return SystemRole::destroy($roleId);
    }

    /**
     * 获取角色列表
     *
     * @return void
     */
    public function getOptions() {
        $list  = [];
        $result = SystemRole::findAll();
        foreach ($result as $item) {
            $temp = [];
            $temp['roleId']      = $item->id;
            $temp['displayName'] = $item->display_name;
            array_push($list, $temp);
        }
        return $list;
    }

}