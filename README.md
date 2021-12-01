# php-image-split-multipart
php auto split/slice image (image split - imageslicer with php)

Call like this:

  `  $slice = new ImageSlicerAuto("source of image file parth","max_width_allow_if_over_1.5_will_be_splited","max_hieght_allow_if_over_1.5_will_be_splited" );`


inde.php file

    <?PHP
    //index.php
    include("slicer.php");
    include("imagesliceauto.php");
    $slice = new ImageSlicerAuto("test1100x7000.jpg",700,1400 );
    echo $slice->json();
    //or 
    echo $slice->show_image();
    ?>





> Written with [StackEdit](https://stackedit.io/).
