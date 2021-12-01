 <?php
include("slicer.php");
include("imagesliceauto.php");
$slice = new ImageSlicerAuto("test1100x7000.jpg",700,1400 );
echo $slice->json();
echo $slice->show_image();
?>
