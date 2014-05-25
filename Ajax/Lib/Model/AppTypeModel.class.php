<?php
class AppTypeModel extends CommonModel {

    public function getList( $map=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );

        $list = $this->order(array('listorder'))->where($map)->select();

        $App = D('App');
        for ( $i=0; $i<count($list); $i++ ) {
            $map = array();
            $map['type_id'] = $list[$i]['type_id'];
            $list[$i]['appCount'] = count( $App->where( $map )->select() );
        }
        return $list;
    }

}
?>