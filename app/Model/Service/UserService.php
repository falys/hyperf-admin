<?php
/**
 * Created by PhpStorm.
 * User: fuan
 * Date: 3/25/20
 * Time: 3:38 PM
 */

namespace App\Model\Service;


use App\Lib\JwtToken;
use App\Lib\Utils;
use App\Model\Dao\PermissionDao;
use App\Model\Dao\UserDao;
use App\Model\Entity\User;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

class UserService
{
    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    /**
     * @Inject()
     * @var UserDao
     */
    private $userDao;

    /**
     * @Inject()
     * @var PermissionDao
     */
    private $permissionDao;

    /**
     * @Inject()
     * @var JwtToken
     */
    private $jwtToken;


    private $errMessage;

    /**
     * 用户登录
     * @param array $data
     * @return array|bool
     */
    public function login(array $data) {
        $result = [];
        $user = $this->userDao->getUserInfo($data['username']);
        if(!$user) {
            $this->errMessage = '账号不存在';
            return false;
        }
        if(md5(md5($data['password']).$user->salt) != $user->password || empty($user)) {
            $this->errMessage = '账号密码错误';
            return false;
        }
        $iat = time();
        $ttl = config('jwt.ttl');
        $tokenCache = $this->redis->get('JWT_'.$user->id);
        if($tokenCache) {
            $token = $tokenCache;
        } else {
            $token = $this->jwtToken->createToken($user->id, $iat);
        }

        $result['userId']       = $user->id;
        $result['nickname']     = $user->nickname;
        $result['token']        = $token;
        $result['tokenExpire']  = $iat + $ttl;
        return $result;
    }

    /**
     * 刷新token
     * @param string $token
     * @return array|bool
     */
    public function refreshToken(string $token) {
        $result = $this->jwtToken->refreshToken($token);
        if($token === false) {
            $this->errMessage = "token失效, 请重新登录";
            return false;
        }
        $this->redis->set('JWT_'.$result['userid'], $result['token']);
        return ['token'=> $result['token']];
    }

    /**
     * 注销登录
     * @param string $token
     * @return bool
     */
    public function logout(string $token) {
        $userId = $this->jwtToken->getUidByToken($token);
        $this->redis->delete('JWT_'.$userId);
        return true;
    }

    public function getList(array $data) {
        return $this->userDao->getUserList($data['page'], $data['pageSize']);
    }

    public function userSearch(string $keyword) {
        return $this->userDao->userSearch($keyword);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public function create(array $data) {
        return $this->userDao->create($data);
    }

    /**
     * 修改
     * @param array $data
     * @return bool
     */
    public function update(array $data) {
        return $this->userDao->update($data);
    }

    /**
     * 删除
     * @param integer $userid
     * @return int
     */
    public function delete(int $userid) {
        return $this->userDao->delete($userid);
    }


    /**
     * 判断是否有权限
     * @param string $uri
     * @return bool
     */
    public function hasPermission(string $userId, string $uri) {
        $result = $this->permissionDao->hasPermission($userId, $uri);
        if($result) {
            return true;
        }
        return false;
    }

    public function isPermission(string $uri) {
        $result = $this->permissionDao->isPermissionUri($uri);
        if($result > 0) {
            return true;
        }
        return false;
    }


    /**
     * 获取用户导航
     * @param string $userId
     * @return array
     */
    public function getNav(string $userId) {
        $result = [];
        $routes = [];
        $routeData = $this->permissionDao->getPermissionByUserid($userId,1);
        foreach ($routeData as $val) {
            $temp = [];
            $temp['permissionId'] = $val->id;
            $temp['parentId']     = $val->parent_id;
            $temp['name']         = $val->name;
            $temp['displayName']  = $val->display_name;
            $temp['effectUri']    = $val->effect_uri;
            $temp['icon']         = $val->icon;
            array_push($routes, $temp);
        }
        $result['routes']  = $routes;
        $result['navlist'] = $this->_getUserPermission($userId, 1);
        return $result;
    }

    /**
     * 获取所有按钮
     * @param string $userid
     * @return array
     */
    public function getButtons(string $userid) {
        $result = [];
        $data = $this->permissionDao->getPermissionByUserid($userid, 0);
        foreach ($data as $item) {
            array_push($result, $item->name);
        }
        return $result;
    }

    private function _getUserPermission(string $userid, int $type, int $parentId = 0) {
        $i = 0;
        $list = [];
        $menuList = $this->permissionDao->getPermissionByUserid($userid, $type, $parentId);
        foreach ($menuList as $key => $val)
        {
            $list[$i]['permissionId'] = $val->id;
            $list[$i]['parentId']     = $val->parent_id;
            $list[$i]['name']         = $val->name;
            $list[$i]['displayName']  = $val->display_name;
            $list[$i]['effectUri']    = $val->effect_uri;
            $list[$i]['description']  = $val->description;
            $list[$i]['isNav']        = $val->is_nav;
            $list[$i]['navDec']       = $val->is_nav==1 ? "导航菜单" : '按钮';
            $list[$i]['icon']         = $val->icon;
            $list[$i]['hidden']       = $val->hidden;
            $list[$i]['order']        = $val->order;
            $children = $this->_getUserPermission($userid, $type, $val->id);
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