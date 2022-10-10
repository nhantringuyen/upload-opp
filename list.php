<?php
    $image = glob('data/125-*');
    usort($image, function($a,$b){
        return filemtime($a) - filemtime($b);
    });
    $xhtml = '<h3>Không có dữ liệu!</h3>';
    if(!empty($image)){
        $xhtml = '';
        foreach($image as $imageSrc){
            $xhtml .=  '<div class="col-md-2 text-center">
                <div class="thumbnail">
                    <img src="'. $imageSrc .'" />
                    <div class="caption">
                        <a href="#" class="badge badge-success" data-toggle="modal" data-target="#myModal" onclick="javascript:showImage(\''.$imageSrc.'\')">View</a>
                        <a href="#" class="badge badge-success" role="button" onclick="javascript:deleteImage(\''.$imageSrc.'\')">Delete</a>
                    </div>
                </div>
            </div>';
        }
    }
    echo $xhtml;
 ?>

               