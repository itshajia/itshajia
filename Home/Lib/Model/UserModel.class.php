<?php
class UserModel extends CommonModel {


    // 自动验证
    protected $_validate = array(
        array('email', 'require', '请填写邮箱！', 1),
        array('email', '', '邮箱已注册！', 1, 'unique', 3),
        array('username', 'require', '请填写用户名！', 1),
        array('password', 'require', '请填写用户密码！', 1),
        array('repassword', 'require', '请填写确认密码！', 1),
        array('repassword', 'password', '密码不一致！', 1, 'confirm'),
        array('username', '', '账号名称已存在！', 1, 'unique', 3)
    );

    // 注册完成后，获取用户完整信息
    public function getUserInfo( $map = array() ) {
        $user = $this->join('JOIN '.$this->tablePrefix.'user_group USING (group_id)')->where($map)->find();
        return $user;
    }


    // 验证用户是否存在
    public function is_exist($username, $password){
        $where = array(
            'username' => $username,
            'password' => md5($password)
        );
        $user = $this->join('JOIN '.$this->tablePrefix.'user_group USING (group_id)')->where($where)->find();
        return $user;
    }

    // 联合 user_group 表
    public function getListWithJoin($map = array()) {
        return $this->join('JOIN '.$this->tablePrefix.'user_group USING (group_id)')->where($map)->select();
    }

    // 数据格式化
    public function data_format() {
        $this->password = md5($this->password);
        $this->reg_ip = get_client_ip();
    }


}
?>