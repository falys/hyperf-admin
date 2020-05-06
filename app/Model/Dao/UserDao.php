<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/25/20
 * Time: 3:38 PM
 */

namespace App\Model\Dao;


use App\Lib\Utils;
use App\Model\Entity\User;
use Co\Mysql\Exception;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class UserDao
{
    /**
     * @Inject()
     * @var Utils
     */
    private $utils;

    /**
     * 根据用户名或者手机号码查询用户
     * @param string $queryStr
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function getUserInfo(string $queryStr) {
        return User::query()
            ->where(['mobile' => $queryStr])
            ->orWhere(['username'=>$queryStr])
            ->first();
    }

    /**
     * 用户列表
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getUserList(int $page=1, int $pageSize = 10) {
        $list  = [];
        $data  = [];
        $total  = Db::table('user')->count();
        $result = Db::table('user')->offset(($page-1)*$pageSize)->limit($pageSize)->get();
        foreach ($result as $item) {
            if($item->status == 1) {
                $statusStr = "启用";
            }else{
                $statusStr = "禁用";
            }
            $temp = [];
            $temp['userid']    = $item->id;
            $temp['mobile']    = $item->mobile;
            $temp['username']  = $item->username;
            $temp['email']     = $item->email;
            $temp['nickname']  = $item->nickname;
            $temp['status']    = $item->status;
            $temp['statusStr'] = $statusStr;
            $temp['createAt']  = $item->created_at;
            array_push($list, $temp);
        }
        $data['list']  = $list;
        $data['total'] = $total;
        return $data;
    }

    /**
     * 用户列表
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function userSearch(string $mobile) {
        $data  = [];
        $result = Db::table('user')->where('mobile', 'like','%'.$mobile.'%')->get();
        foreach ($result as $item) {
            $temp['userid'] = $item->id;
            $temp['value']  = $item->mobile.'('.$item->nickname.')';
            array_push($data, $temp);
        }
        return $data;
    }

    /**
     * 添加用户
     * @param array $data
     * @return bool
     */
    public function create(array $data) {
        $user = new User();
        $salt = $this->utils->randString();
        $user->mobile   = $data['mobile'];
        $user->username = $data['username'];
        $user->email    = $data['email'];
        $user->password = md5(md5($data['password']).$salt);
        $user->salt     = $salt;
        $user->nickname = $data['nickname'];
        if($user->save()) {
            return true;
        }
        return false;
    }

    /**
     * 添加用户
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        $user = User::query()->where('id', $data['userid'])->first();
        if($data['mobile']) {
            $user->mobile   = $data['mobile'];
        }
        if(isset($data['username']) ) {
            $user->username = $data['username'];
        }
        if(isset($data['avatar'])) {
            $user->avatar   = $data['avatar'];
        }
        if(isset($data['nickname'])) {
            $user->nickname = $data['nickname'];
        }
        if(isset($data['status'])) {
            $user->status   = $data['status'];
        }

        if($user->save()) {
            return true;
        }
        return false;
    }

    /**
     * 删除用户
     * @param string $userid
     * @return int
     */
    public function delete(string $userid) {
        return User::destroy($userid);
    }

}