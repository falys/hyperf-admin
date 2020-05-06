<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/30/20
 * Time: 10:05 PM
 */

namespace App\Validation;


use App\Validation\Validate\BaseValidation;

class PermissionValidation extends BaseValidation
{
    protected $rule = [
        'permissionId' => 'require',
        'name'          => 'require|unique:system_permissions,name',
        'parentId'      => 'integer',
        'displayName'   => 'require',
    ];

    protected $message = [
        'permissionId.require' => '请选择要操作权限',
        'name.require'          => '请输入权限名',
        'name.unique'           => '同名权限已存在',
        'parentId.integer'      => '父权限ID错误',
        'displayName.require'   => '请输入权限名称'
    ];

    protected $scene = [
        'create' => ['name','parentId','displayName'],
        'update' => ['permissionId', 'displayName'],
        'delete' => ['permissionId']
    ];
}