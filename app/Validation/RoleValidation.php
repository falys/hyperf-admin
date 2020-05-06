<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/30/20
 * Time: 10:30 PM
 */

namespace App\Validation;


use App\Validation\Validate\BaseValidation;

class RoleValidation extends BaseValidation
{
    protected $rule = [
        'page'          => 'integer',
        'pageSize'      => 'integer',
        'roleId'        => 'require',
        'name'          => 'require|unique:system_permissions,name',
        'displayName'   => 'require',
    ];

    protected $message = [
        'page.integer'        => '请输入正确输入页码',
        'pageSize.integer'    => '请输入正确输入每页展示条数',
        'roleId.require'      => '请选择要操作的角色',
        'name.require'        => '请输入角色名',
        'name.unique'         => '同名角色已存在',
        'mobile.moblie'       => '请输入正确的手机号码',
        'mobile.unique'       => '请输入正确的手机号码',
        'displayName.require' => '请输入权限描述'
    ];

    protected $scene = [
        'list'   => ['page', 'pageSize'],
        'create' => ['name', 'displayName'],
        'update' => ['roleId', 'displayName'],
        'delete' => ['roleId']
    ];
}