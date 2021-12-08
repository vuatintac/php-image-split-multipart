# php-image-split-multipart
php auto split/slice image (image split - imageslicer with php)

Call like this:

  `  $slice = new ImageSlicerAuto("source of image file parth","max_width_allow_if_over_1.5_will_be_splited","max_hieght_allow_if_over_1.5_will_be_splited" );`


inde.php file

    <?PHP
    //index.php
    include("slicer.php");
    include("imagesliceauto.php");
    $slice = new ImageSlicerAuto("test-600x3818-165Kb.png",700,370 );
    $array =  $slice->array();
    print_r($array);
    echo $slice->json();
    echo $slice->show_image();
    ?>





> Written with [StackEdit](https://stackedit.io/).
