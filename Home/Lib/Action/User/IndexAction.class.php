<?php
/**
 * 会员中心 Action
 */
class IndexAction extends Action {

    public function index(){
        // 检测用户是否登录
        A('User/Common');
        $this->display('index');
    }

    // 用户注册
    public function register() {
        $this->display('register');
    }

    // 用户注册验证
    public function register_do () {
        $User = D('User');

        if( $User->create() ) {
            // 用户注册审核
            $Config = D('Config');
            $map = array();
            $map['config_key'] = 'register_check';
            $config = $Config->where($map)->find();

            $User->data_format();
            $User->addtime = time();
            $User->group_id = 3;

            if ( $config['config_value'] ) {
                $User->status = 0;
            }else {
                $User->status = 1;
            }

            if( $User->add() ) {
                // 注入登录状态
                $map = array();
                $map['username'] = $_POST['username'];
                $user = $User->getUserInfo($map);

                if ( !$config['config_value'] ) {
                    $_SESSION['_User'] = $user;
                    $this->success('注册成功！', appUrl('') );
                } else {
                    $this->success('注册成功，请联系管理员进行审核！', appUrl('') );
                }
                //$_SESSION['_User'] = $user;


            } else {
                $this->assign('reg', '1');
                $this->assign('error', '注册失败！');
                $this->display('login');
            }
        } else {
            $this->assign('reg', '1');
            $this->assign('error', '注册失败！');
            $this->display('login');
        }

    }

    // 用户登录
    public function login () {
        // 检测用户是否登录
        A('User/Common');
        $this->display('login');
    }

    // 用户登录验证
    public function login_do () {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)){
            $User = D('User');
            $user = $User->is_exist($username, $password);
            // 允许登录的 用户类型
            //$ids = array(3);

            if ( $user ){
                if ( $user['status'] ) {
                    session('_User', $user);
                    $this->redirect( appUrl('') );
                } else {
                    $this->assign('error', '您的注册信息正在审核中！');
                    $this->display('login');
                }

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
    public function logout() {
        session('_User', null);
        $this->redirect( appUrl('m=Index&a=login') );
    }






}