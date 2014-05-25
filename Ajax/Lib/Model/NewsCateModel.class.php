<?php
class NewsCateModel extends CommonModel{

    public function getList( $map=array(), $limit=array() ) {
        $list = $this->where($map)->order(array('listorder'))->limit($limit['page'].','.$limit['pagesize'])->select();
        foreach( $list as $k=>$v ) {
            $obj = $this->where(array('cate_id'=> $v['parent_id']))->find();
            $list[$k]['cate_pname'] = $obj ? $obj['cate_name'] : '顶级分类';

        }
        return $list;
    }

}
?>