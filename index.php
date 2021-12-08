 <?php
include("slicer.php");
include("imagesliceauto.php");
$slice = new ImageSlicerAuto("test-600x3818-165Kb.png",700,370 );
$array =  $slice->array();
print_r($array);
echo $slice->json();
echo $slice->show_image();
?>
