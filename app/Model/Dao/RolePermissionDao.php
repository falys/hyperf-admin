<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/30/20
 * Time: 4:54 PM
 */

namespace App\Model\Dao;


use App\Model\Entity\SystemRolesPermission;
use Hyperf\DbConnection\Db;

class RolePermissionDao
{


    /**
     * 权限分配
     * @param array $params
     * @return bool
     */
    public function assignPermission(array $params) {
        if(empty($params['old'])){
            $insertData = [];
            foreach ($params['permissions'] as $item) {
                $temp = [];
                $temp['system_role_id']       = $params['roleId'];
                $temp['system_permission_id'] = $item;
                array_push($insertData, $temp);
            }
            $ret = Db::table('system_roles_permissions')->insert($insertData);
            if($ret) {
                return true;
            }
        } else {
            if(count($params['old'])>count($params['permissions'])) {
                $diffMenu = array_diff($params['old'],$params['permissions']);
            }
            else {
                $diffMenu = array_diff($params['permissions'],$params['old']);
            }
            $err = 0;
            Db::beginTransaction();
            try {
                foreach ($diffMenu as $item) {
                    if (in_array($item, $params['old'])) {
                        $where['system_role_id']       = $params['roleId'];
                        $where['system_permission_id'] = $item;
                        $ret = Db::table('system_roles_permissions')->where($where)->delete();
                        if ($ret===false) {
                            $err++;
                        }
                    } else {
                        $temp['system_role_id']       = $params['roleId'];
                        $temp['system_permission_id'] = $item;
                        $ret = Db::table('system_roles_permissions')->insert($temp);;
                        if ($ret===false) {
                            $err++;
                        }
                    }
                }
                if($err>0) {
                    Db::rollback();
                    return false;
                }
                Db::commit();
            } catch (Exception $e){
                Db::rollback();
                return false;
            }
            return true;
        }
        return false;
    }


    public function getRolePermissionsByRoleId(int $roleId) {
        $data   = [];
        $result = Db::table('system_roles_permissions')->where('system_role_id',$roleId)->get();
        foreach ($result as $item ){
            array_push($data, $item->system_permission_id);
        }
        return $data;
    }
}