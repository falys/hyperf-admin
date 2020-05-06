<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/26/20
 * Time: 5:08 PM
 */

namespace App\Validation;


use App\Validation\Validate\BaseValidation;

class UserValidation extends BaseValidation
{
    protected $rule = [
        'page'          => 'integer',
        'pageSize'      => 'integer',
        'userid'        => 'require',
        'username'      => 'require',
        'password'      => 'require',
        'checkPassword' => 'require|confirm:password',
        'mobile'        => 'require|mobile',
        'email'         => 'require|email',
        'avatar'        => 'require'
    ];

    protected $message = [
        'page.integer'          => '请输入正确输入页码',
        'pageSize.integer'      => '请输入正确输入每页展示条数',
        'userid.require'        => '请选择要操作用户',
        'username.require'      => '请输入用户名',
        'username.unique'       => '同用户名的用户已存在',
        'password.require'      => '请输入密码',
        'checkPassword.require' => '请输入确认密码',
        'checkPassword.confirm' => '两次密码不一致',
        'mobile.require'        => '请输入手机号码',
        'mobile.mobile'         => '请输入正确的手机号码',
        'mobile.unique'         => '相同手机号码的用户已存在',
        'email.require'         => '请输入邮箱地址',
        'email.email'           => '请输入正确的邮箱地址',
    ];

    protected $scene = [
        'list'        => ['page','pageSize'],
        'login'       => ['username','password'],
        'create'      => ['username','password', 'checkPassword', 'mobile', 'email'],
        'update'      => ['userid','nickname','mobile', 'email'],
        'delete'      => ['userid']
    ];
}