<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP Show Data</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php 
        // echo
    session_start();
    if(!empty($_FILES)) {
        if(isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']){
            unset($_SESSION['token']);
            header('Location: index.php');
            exit();
        }else{
            $_SESSION['token'] = $_POST['token'];
        }
        require_once 'class/Upload.class.php';
        $upload = new Upload('file-upload');
        $upload->setFileSize(0, 4000000);
        $upload->setFileExtension(array('doc', 'docx', 'zip', 'jpg', 'png'));
        $upload->setUploadDir('data/');
        // echo '<pre>';
        // print_r($upload);
        // echo '</pre>';
        $message = '';
        if ($upload->isVail()) {
            $upload->upload();
            $message = '<p class="alert alert-info">Success</p>';
        } else {
            $message = $upload->showError();
        }
    }
    ?>    
    <div class="container my-content">
        <h1 class="page-header text-center">PHP OOP - Upload File</h1>
            <!-- FORM UPLOAD -->
            <form action="#" method="post" id="main-form" name="main-form" class="form-group d-flex justify-content-end" enctype="multipart/form-data">
                <input type="file" id="file-upload" name="file-upload" style="display: none;">
                <input type="hidden" id="token" name="token" value="<?php echo time(); ?>">
                <a class="btn btn-info mr-sm-2" id="select-file" href="#" onclick="javascript:openFile()">Select File</a>
                <button type="submit" class="btn btn-primary" disabled>Upload</button>
            </form>
        <!-- ERROR -->
        <?php echo !empty($_FILES) ? $message : ''; ?>
        <div class="content-course">
            <!-- IMAGE INFO -->
            <div class="row">
                
            </div>
        </div>
        <!-- POPUP -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-badgeledby="myModalbadge" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function openFile() {
            jQuery("#file-upload").click();
            return false;
        }
        function loadImages(){
            jQuery(".content-course .row").load('list.php')
        }
        function showImage(imageSrc){
            var image = imageSrc.replace('125-','450-');
            jQuery("#myModal .modal-body").html('<img src="'+ image +'">')
        }
        function deleteImage(imageSrc){
            jQuery.ajax({
                url   : 'delete.php',
                type : 'POST',
                data : {imageSrc: imageSrc},
                success : function(data){
                    //loadImages();
                    $(".content-course  .thumbnail img[src='"+ imageSrc +"']").parents(".col-md-2").remove();
                } 
            });
        }
        jQuery(document).ready(function($) {
            loadImages();
            $("#file-upload").on("change", function() {
                let filename = this.value.split('\\').pop();
                $("#select-file").text(filename);
                $("button[type=submit]").removeAttr('disabled');
            });
        });
    </script>
</body>

</html>