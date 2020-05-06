<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/25/20
 * Time: 3:38 PM
 */

namespace App\Model\Dao;


use App\Lib\Utils;
use App\Model\Entity\SystemPermission;
use App\Model\Entity\User;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use phpDocumentor\Reflection\Type;

class PermissionDao
{



    /**
     *  权限列表
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getList(int $pid) {
        $list  = [];
        $result = Db::table('system_permissions')->where('parent_id', $pid)->get();
        foreach ($result as $item) {
            $temp = [];
            $temp['permissionId'] = $item->id;
            $temp['parentId']     = $item->parent_id;
            $temp['name']         = $item->name;
            $temp['displayName']  = $item->display_name;
            $temp['effectUri']    = $item->effect_uri;
            $temp['description']  = $item->description;
            $temp['icon']         = $item->icon;
            $temp['isNav']        = $item->is_nav;
            $temp['order']        = $item->order;
            array_push($list, $temp);
        }
        return $list;
    }

    /**
     * 添加权限
     * @param array $data
     * @return bool
     */
    public function create(array $data) {
        $permission = new SystemPermission();
        $permission->parent_id    = $data['parentId'];
        $permission->name         = $data['name'];
        $permission->display_name = $data['displayName'];
        $permission->effect_uri   = $data['effectUri'];
        $permission->description  = $data['description'];
        $permission->icon         = $data['icon'];
        $permission->is_nav       = $data['isNav'];
        $permission->hidden       = $data['hidden'];
        $permission->order        = isset($data['order']) ? $data['order'] : 0;
        if($permission->save()) {
            return true;
        }
        return false;
    }

    /**
     * 修改权限
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        $user = SystemPermission::query()->where('id', $data['permissionId'])->first();
        if(isset($data['displayName']) ) {
            $user->display_name = $data['displayName'];
        }
        if(isset($data['effectUri'])) {
            $user->effect_uri   = $data['effectUri'];
        }
        if(isset($data['description'])) {
            $user->description = $data['description'];
        }
        if(isset($data['icon'])) {
            $user->icon   = $data['icon'];
        }
        if(isset($data['isNav'])) {
            $user->is_nav = $data['isNav'];
        }
        if(isset($data['hidden'])) {
            $user->hidden = $data['hidden'];
        }
        if(isset($data['order'])) {
            $user->order   = $data['order'];
        }

        if($user->save()) {
            return true;
        }
        return false;
    }

    /**
     * 删除删除权限
     * @param integer $permissionId
     * @return int
     */
    public function delete(int $permissionId) {
        return SystemPermission::destroy($permissionId);
    }

    /**
     * 根据用户ID获取权限
     * @param string $userid
     * @param int $type
     * @param int $parentId
     * @return \Hyperf\Utils\Collection
     */
    public function getPermissionByUserid(string $userid, int $isNav, int $parentId = -1) {

        if($parentId == -1) {
            $where = ['system_permissions.is_nav'=>$isNav,'user.id'=>$userid];
        } else {
            $where = ['system_permissions.is_nav'=>$isNav,'system_permissions.parent_id'=>$parentId,'user.id'=>$userid];
        }

        $result = Db::table('user')
                ->join('system_roles_user', 'user.id', '=', 'system_roles_user.user_id')
                ->join('system_roles_permissions', 'system_roles_user.system_role_id', '=', 'system_roles_permissions.system_role_id')
                ->join('system_permissions', 'system_permissions.id','=', 'system_roles_permissions.system_permission_id')
                ->select('system_permissions.*')
                ->where($where)
                ->get();
        return $result;
    }

    /**
     * 判断是否有权限
     *
     *
     * @param string $userid
     * @param string $uri
     * @return int
     */
    public function hasPermission( string $userid, string $uri) {
        $result = Db::table('user')
            ->join('system_roles_user', 'user.id', '=', 'system_roles_user.user_id')
            ->join('system_roles_permissions', 'system_roles_user.system_role_id', '=', 'system_roles_permissions.system_role_id')
            ->join('system_permissions', 'system_permissions.id','=', 'system_roles_permissions.system_permission_id')
            ->where(['system_permissions.effect_uri'=>$uri, 'user.id'=>$userid])
            ->count();
        return $result;
    }

    /**
     * 判断是否为权限URI
     *
     * @param string $uri
     * @return boolean
     */
    public function isPermissionUri(string $uri) {
        $result = SystemPermission::where('effect_uri',$uri)->count();
        return $result;
    }

}