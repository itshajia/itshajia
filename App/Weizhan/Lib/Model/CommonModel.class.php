<?php
class CommonModel extends Model{

    // 获取 数据总数量
    public function getCount( $map = array() ) {
        $list = $this->where( $map )->select();
        return  $list ? count($list) : 0;
    }

    /**
     * 获取 “无限极分类” 有结构类型的
     * 例如：$list = array(
     *  ... => ...
        'children' => array(
            ... => ...
     *      'children' => array()
     * )
     * );
     */
    public function getUnlimit( $map=array(), $parent_id=0, $i=-1, $parent_id_name='parent_id', $cate_id_name='cate_id' ,$order=array('listorder') ) {
        $i++;

        $map[$parent_id_name] = $parent_id;
        $Unlist = $this->order($order)->where($map)->select();
        foreach( $Unlist as $k=>$v ) {
            $obj = $this->where(array('cate_id'=> $v['parent_id']))->find();
            $Unlist[$k]['cate_pname'] = $obj ? $obj['cate_name'] : '顶级分类';
            $Unlist[$k]['children'] = $this->getUnlimit($map, $v[$cate_id_name], $i );
            $Unlist[$k]['level'] = $i;
        }
        return $Unlist;
    }

    public function getUnlimitIds( $ids=array(), $map=array(), $parent_id=0, $i=-1, $parent_id_name='parent_id', $cate_id_name='cate_id' ,$order=array('listorder') ) {
        $i++;

        array_push($ids, $parent_id);
        $map[$parent_id_name] = $parent_id;
        $Unlist = $this->order($order)->where($map)->select();
        foreach( $Unlist as $k=>$v ) {
            array_push($ids, $v['cate_id']);
            $ids = $this->getUnlimitIds($ids, $map, $v[$cate_id_name], $i );
        }
        $ids = array_unique($ids);
        $ids = array_filter($ids);
        return $ids;
    }

    /**
     * 对 “无限极分类” 加工，转为“无结构类型，但有层次”
     */
    public function getLevelUnlimit($list=array(), $levelList=array()) {
        if ( count($list) ) {
            foreach( $list as $k=>$v ) {
                $item = $v;
                $item['children'] = "";
                array_push( $levelList, $item );
                $levelList = $this->getLevelUnlimit( $v['children'], $levelList);
            }
        }
        return $levelList;
    }
}
?>