<?php

include("slicer.php");

@$picture               = $_GET['picture']	    ? $_GET['picture']      : "test.jpg";
@$pie                   = $_GET['pie']          ? $_GET['pie']          : 1 ;
@$max_width_allow       = $_GET['width']        ? $_GET['width']        : 1000; //px
@$max_height_allow      = $_GET['height']       ? $_GET['height']       : 1000;//px
@$ext                   = $_GET['ext']          ? $_GET['ext']          : "jpg";
 


list($pic_width, $pic_height, $type, $attr) = getimagesize($picture);

// Để đảm bảo chiều cao của các ảnh xuất ra ko dc vượt quá $max_height_allow , 
// nếu chiều cao dư ra lớn hơn 1/x height thì số số dòng chia ảnh $hor bằng  $ratio_height +1, ngược lại $hor = $hor
// mục đích, VD chiếu cao giới hạn là: 1000px, nếu ảnh cao 1300px, thì ko cần cắt, ảnh cao 1600px thì cắt thành 2 ảnh 800px,
//echo $pic_height/$max_height_allow;
$hor  =  round($pic_width/$max_width_allow) > 1 ? round($pic_width/$max_width_allow) : 1;
$ver  =  round($pic_height/$max_height_allow) > 1 ? round($pic_height/$max_height_allow) : 1;


// echo "- pic_width: ", $pic_width, " --------- pic_height: ", $pic_height  ;
// echo "- max_width_allow:", $max_width_allow;
// echo "- max_height_allow:", $max_height_allow;
// die;
// echo "- hor: ", $hor  ;
// echo "- ver: ", $ver   ;
//  die;

$slice = new Slicer();
$slice->set_picture($picture);
$slice->set_slicing($hor,$ver);
$slice->set_typeoutput($ext);
$slice->show_slice($pie);
 
?>