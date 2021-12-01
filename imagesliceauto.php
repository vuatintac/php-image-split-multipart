<?php

## 
## v1.0	 ## 15 August 2004
## ImageSlicer
######
## This class meant to generate sliced image
## that contained in a table
## It can make your pictures smaller in each size.
##
#######
## Author: Huda M Elmatsani
## Email: 	justhuda at netrada.co.id
##
## 15/08/2004
#######
## Copyright (c) 2004 Huda M Elmatsani All rights reserved.
## This program is free for any purpose use.
########
##
## NOTES
##
## file slice.php is the sliced image output.
## file slicer.php is a class for slicing image.
## file imageslice.php (this file) is compose the sliced image into a table.
## file sample1.php is sample output.
####

class ImageSlicerAuto {

	var $picture			    = 	"";
	var $pic_width			    = 	0;
	var	$pic_height			    =	0;
	var $slice_hor			    = 	0;
	var	$slice_ver			    =	0;
	var $tbl_border			    = 	5;
	var $max_width_allow		= 	500;
	var $max_height_allow	    = 	500;
 


	function __construct ($picture,$max_width_allow, $max_height_allow) {

		$this->picture			    = 	$picture;
		//echo "- max_width_allow:" ,
		 $this->max_width_allow		= 	$max_width_allow;
		//echo "- max_height_allow:" , 
		 $this->max_height_allow	    = 	$max_height_allow;

		$picinfo = @getimagesize ($picture);
       // print_r($picinfo);
   		if ($picinfo !== false) {
     		$pic_width      = $picinfo [0];
     		$pic_height     = $picinfo [1];
		}

        //list($pic_width, $pic_height, $pic_type, $pic_attr) = getimagesize($picture);
        // echo "width: ", $pic_width, " --------- height: ", $pic_height  ;
        // Để đảm bảo chiều cao của các ảnh xuất ra ko dc vượt quá $max_height_allow , 
        // nếu chiều cao dư ra lớn hơn 1/x height thì số số dòng chia ảnh $hor bằng  $ratio_height +1, ngược lại $hor = $hor
        // mục đích, VD chiếu cao giới hạn là: 1000px, nếu ảnh cao 1300px, thì ko cần cắt, ảnh cao 1600px thì cắt thành 2 ảnh 800px,
		//echo "- slice_ver:" , 
		$this->slice_ver	= round( $pic_height/$max_height_allow ) ;
		//echo "- slice_hor:" , 
		$this->slice_hor	= round( $pic_width/$max_width_allow) ;
		$this->pic_width	= $pic_width;

	}

	
	function create_array() {
		$slice = new Slicer();
		$slice->set_picture($this->picture);
		$slice->set_slicing($this->slice_hor, $this->slice_ver );
 		$slice->set_typeoutput("webp");

        $return = [];
		$pie=1;
		for($i=0 ; $i<$this->slice_ver ; $i++){
			for($j=0 ; $j<$this->slice_hor ; $j++){
    			$return[] = $slice->create_slice_to_file($pie);
    			//$return[] = "sliceauto.php?picture=$this->picture&pie=$k&ext=webp&width=$this->max_width_allow&height=$this->max_height_allow";
				$pie++;
			}
		}
		return $return;
	}
	function json() {

		return json_encode($this->create_array(), JSON_UNESCAPED_UNICODE);
	}


	function set_border($border=2) {
		$this->tbl_border = $border;
	}


	function create_imageslice() {
		$str_table = "<table width=\"$this->pic_width\" border=\"$this->tbl_border\" cellspacing=\"0\" cellpadding=\"0\">";
		$k=1;
		for($i=0 ; $i<$this->slice_ver ; $i++){
  			$str_table .= "<tr>";
			for($j=0 ; $j<$this->slice_hor ; $j++){
    			$str_table .= "<td><img src=\"sliceauto.php?picture=$this->picture&pie=$k&ext=webp&width=$this->max_width_allow&height=$this->max_height_allow\"></td>";
				$k++;
			}
  			$str_table .= "</tr>";
		}
		$str_table .= "</table>";
		return $str_table;
	}

	function show_image() {
		echo $this->create_imageslice();
	}

}

?>