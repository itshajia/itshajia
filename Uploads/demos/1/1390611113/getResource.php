<?php
if( $_POST['index'] && $_POST['index']<5) {
    $imgArr = array();
    for( $i=1;$i<5;$i++) {
        $arr = array();
        for( $j=1;$j<=4;$j++) {
            //array_push($arr, './Images/'.$i.'-'.$j.'.jpg');
            /*if($j==4) {
                $xx ='';
            } else {
                $xx = '';
            }*/
            array_push($arr, array(
                'img' => './Images/'.$i.'-'.$j.'.jpg',
                'linkurl' => 'http://www.itshajia.com'
            ));
        }
        array_push($imgArr ,$arr);
    }
    echo json_encode($imgArr);
}

?>