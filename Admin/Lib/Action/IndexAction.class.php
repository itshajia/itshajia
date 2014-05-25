<?php
/**
 * 后台登录前的所有 action 处理集合
 */

class IndexAction extends Action {

    public function index(){
        // 检测用户是否登录
        A('Common');
        $this->display('index');
    }

    // 用户登录
    public function login(){
        // 检测用户是否登录
        A('Common');
        $this->display('login');
    }

    // 用户登录验证
    public function login_do(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)){
            $Admin = D('Admin');
            $admin = $Admin->is_exist($username, $password);

            if($admin){
                session('_adminUser', $admin);
                $this->redirect(appUrl(''));
            }else{
                $this->assign('error', '用户名或密码不正确！');
                $this->display('login');
            }
        }else{
            $this->assign('error', '用户名或密码不能为空！');
            $this->display('login');
        }
    }

    // 用户退出
    public function logout(){
        session('_adminUser', null);
        $this->redirect( appUrl('m=Index&a=login') );
    }
}