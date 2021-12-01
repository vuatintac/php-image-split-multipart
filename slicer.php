<?php
/*
The purpose of this class is to generate
image pieces by slicing the image
specified by coordinate x,y and width,heigth
*/
class Slicer
{
	var $img_image			= 	"";
	var $picture			= 	"";
	var $pic_width			= 	0;
	var	$pic_height			=	0;
	var $slice_hor			= 	0;
	var	$slice_ver			=	0;
 	var	$img_type			=	"jpg";
	function Slicer()
	{
	}
	function set_picture($pic)
	{
		$this->picture = $pic;
	}
	function set_typeoutput($img_type)
	{
		$this->img_type = strtolower($img_type);
	}
	function get_width()
	{
		return $this->pic_width;
	}
	function set_slicing($horizontal, $vertical)
	{
		$this->slice_hor = $horizontal;
		$this->slice_ver = $vertical;
	}
 
	function create_slice_to_file($n)
	{
		/* make it not case sensitive*/
		$this->img_type 	= strtolower($this->img_type);
		$path_parts  		= pathinfo($this->picture);
		$filename 			= $path_parts['filename'];
		$endingname			= "-h" . $this->slice_hor . "v" . $this->slice_ver . "p" . $n;
		$picture 			= $this->prepare_pieces($n);
		/* show the images  */
		switch ($this->img_type) {
			case 'jpeg':
			case 'jpg':
			case 'jfif':
				$extension = "jpg";
				$newfilename = $filename . $endingname . "." . $extension;
				imagejpeg($picture, $newfilename, 75);
				break;
			case 'gif':
				$extension = "gif";
				$newfilename = $filename . $endingname . "." . $extension;
				imagegif($picture, $newfilename, 75);
				break;
			case 'png':
				$extension = "png";
				$newfilename = $filename . $endingname . "." . $extension;
				imagepng($picture, $newfilename, 6.5);
				break;
			case 'webp':
				$extension = "webp";
				$newfilename = $filename . $endingname . "." . $extension;
				imagewebp($picture, $newfilename, 75);
				break;
			case 'wbmp':
				$extension = "wbmp";
				$newfilename = $filename . $endingname . "." . $extension;
				imagewbmp($picture, $newfilename, 75);
				break;
		}
		return $newfilename;
	}
	function show_slice($n)
	{
		/* make it not case sensitive*/
		$this->img_type 	= strtolower($this->img_type);
		$path_parts  		= pathinfo($this->picture);
		$filename 			= $path_parts['filename'];
		$endingname			= "_h" . $this->slice_hor . "v" . $this->slice_ver . "p" . $n;
		$picture 			= $this->prepare_pieces($n);
		/* show the images  */
		switch ($this->img_type) {
			case 'jpeg':
			case 'jpg':
			case 'jfif':
				$extension = "jpg";
				$newfilename = $filename . $endingname . "." . $extension;
					header("Content-type: image/jpeg");
					imagejpeg($picture, null, 75);
				break;
			case 'gif':
				$extension = "gif";
				$newfilename = $filename . $endingname . "." . $extension;
					header("Content-type: image/gif");
					imagegif($picture, null, 75);
				break;
			case 'png':
				$extension = "png";
				$newfilename = $filename . $endingname . "." . $extension;
					header("Content-type: image/png");
					imagepng($picture, null, 75);
				break;
			case 'webp':
				$extension = "webp";
				$newfilename = $filename . $endingname . "." . $extension;
					header("Content-type: image/webp");
					imagewebp($picture, null, 75);
				break;
			case 'wbmp':
				$extension = "wbmp";
				$newfilename = $filename . $endingname . "." . $extension;
					header("Content-type: image/vnd.wap.wbmp");
					imagewbmp($picture, null, 75);
				break;
		}
		return $newfilename;
	}
	function load_picture()
	{
		/* pick picture you want to frame  */
		if (file_exists($this->picture)) {
			$extension = $this->get_imagetype($this->picture);
			/* create image source from your image strip stock */
			switch ($extension) {
				case 'jpeg':
				case 'jpg':
				case 'jfif':
					$img_picture 	= @imagecreatefromjpeg($this->picture);
					break;
				case 'gif':
					$img_picture 	= @imagecreatefromgif($this->picture);
					break;
				case 'png':
					$img_picture 	= @imagecreatefrompng($this->picture);
					break;
				case 'webp':
					$img_picture 	= @imagecreatefromwebp($this->picture);
					break;
			}
		} else {
			/* if fail to load image file, create it on the fly */
			$img_picture 	= $this->draw_picture();
		}
		return $img_picture;
		imagedestroy($img_picture);
	}
	function draw_picture()
	{
		if ($this->img_image) {
			return $this->img_image;
		} else {
			if (!$this->pic_height)
				$this->set_size(300, 200);
			$img_picture    = imagecreatetruecolor($this->pic_width, $this->pic_height);
			$bg_color		= imagecolorallocate($img_picture, 200, 200, 200);
			imagefill($img_picture, 0, 0, $bg_color);
		}
		return $img_picture;
		imagedestroy($img_picture);
	}
	function set_image($image)
	{
		$this->img_image = $image;
	}
	function get_imagetype($file)
	{
		$acceptable = array("jpg", "jfif", "jpeg", "gif", "png", "webp");
		/* ask the image type */
		$file_info  = pathinfo($file);
		$extension  = $file_info["extension"];
		if (in_array($extension, $acceptable))
			return $extension;
		else
			return null;
	}
	function prepare_pieces($n)
	{
		$img_picture		= 	$this->load_picture();
		$this->pic_width 	= 	imagesx($img_picture);
		$this->pic_height 	= 	imagesy($img_picture);
		/* slice into hor x ver pieces */
		$slice_width	= $this->pic_width / $this->slice_hor;
		$slice_height	= $this->pic_height / $this->slice_ver;
		$x 				= 0;
		$y				= 0;
		$w				= $slice_width;
		$h				= $slice_height;
		$k = 1;
		for ($i = 0; $i < $this->slice_ver; $i++) {
			for ($j = 0; $j < $this->slice_hor; $j++) {
				if ($k == $n)
					$img_piece	= $this->slice_image($img_picture, $x, $y, $w, $h);
				$x	= $x + $w;
				$k++;
			}
			$x = 0;
			$y = $y + $h;
		}
		return $img_piece;
	}
	function slice_image($img_src, $x, $y, $width, $height)
	{
		$img_slice = imagecreatetruecolor($width, $height);
		imagecopyresampled($img_slice, $img_src, 0, 0, $x, $y, $width, $height, $width, $height);
		return $img_slice;
		imagedestroy($img_slice);
	}
}
