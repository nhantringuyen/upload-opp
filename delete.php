<?php 
if(isset($_POST['imageSrc'])){
    $imageName = $_POST['imageSrc'];

    //125 x 125
    $fileName = $imageName;
    @unlink($fileName);
   
     //450 x 450
    $fileName =  str_replace('125-','450-', $imageName)  ; 
    @unlink($fileName);

      //Main
      $fileName =  str_replace('125-','', $imageName) ; 
      @unlink($fileName);
}