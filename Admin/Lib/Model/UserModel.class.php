<?php
class UserModel extends CommonModel {


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
    public function getListWithJoin($map = array(), $limit=array() ) {
        $order = array(
            'addtime'=>'desc',
            'uid' => 'desc'
        );
        return $this->join('JOIN '.$this->tablePrefix.'user_group USING (group_id)')->order($order)->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();
    }

    // 数据格式化
    public function data_format() {
        $this->password = md5($this->password);
        $this->reg_ip = get_client_ip();
    }


}
?>