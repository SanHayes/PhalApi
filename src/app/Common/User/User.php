<?php
namespace App\Common\User;

use App\Domain\User\User as UserDomain;
use App\Domain\User\UserSession as UserSessionDomain;

/**
 * 用户插件-用户服务
 * @author dogstar 20200331
 *
 */
class User {
    protected $id = 0;
    protected $profile = array();
    
    public function __construct() {
        $uid = \PhalApi\DI()->request->get('uid');
        $uid = intval($uid);
        $token = \PhalApi\DI()->request->get('token');
        
        if ($uid && $token) {
            $domain = new UserSessionDomain();
            $is_login = $domain->checkSession($uid, $token);
            
            if ($is_login) {
                $this->login($uid);
            }
        }
    }
    
    // 登录用户
    public function login($uid) {
        $userDomain = new UserDomain();
        $profile = $userDomain->getUserInfo($uid, 'uid,username,nickname,utime,portrait,utel');
        $this->profile = $profile ? $profile : $this->profile;
        $this->id = $uid;
    }
    
    // 是否已登录
    public function isLogin() {
        return $this->id > 0 ? true : false;
    }
    
    // 获取用户ID
    public function getUserId() {
        return $this->id;
    }
    
    // 获取个人资料
    public function getProfile() {
        return $this->profile;
    }
    
    // 获取指定字段
    public function getProfileBy($filed, $default = NULL) {
        return isset($this->profile[$filed]) ? $this->profile[$filed] : $default;
    }
    
    // 获取资料
    public function __get($name) {
        return isset($this->profile[$name]) ? $this->profile[$name] : NULL;
    }
}
