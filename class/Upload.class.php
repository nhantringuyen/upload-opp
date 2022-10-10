<?php
require_once 'phpthumb.class.php';
class Upload{

//Biến lưu trữ tên tập tin
private $_fileName;

//Biến lưu trữ kích thước tập tin
private $_fileSize;

//Biến lưu trữ phần mở rộng tập tin
private $_fileExtension;

//Biến lưu trữ đường dẫn thư mục tạm
private $_fileTmp;

//Biến lưu trữ lỗi
private $_error = [];

//Biến lưu trữ đường dẫn upload
private $_uploadDir;

// Phương thức khởi tạo 
public function __construct($fileName){
    $fileInfo               = $_FILES[$fileName];
    $this->_fileName        = $fileInfo['name'];
    $this->_fileSize        = $fileInfo['size'];
    $this->_fileExtension   = $this->getFileExtension();
    $this->_fileTmp         = $fileInfo['tmp_name'];
}

//Phương thức lấy phần mở rộng
private function getFileExtension(){
    $ext = pathinfo($this->_fileName, PATHINFO_EXTENSION);
    return $ext;
}

//Phương thức thiết lập lấy phần mở rộng
public function setFileExtension($arrExtension){
    if(in_array(strtolower($this->_fileExtension),$arrExtension) == false){
        $this->_error[] = "Phan mo rong khong phu hop";
    }
}

//Phương thức thiết lập kích thước tối thiểu và kích thước tối đa được cho phép
public function setFileSize($min, $max){
    if($this->_fileSize < $min || $this->_fileSize > $max){
        $this->_error[] = "Kich thuoc khong phu hop";
    }
}

//Phương thức thiết lập đường dẫn đến folder upload
public function setUploadDir($value){
    if(file_exists($value)){
        $this->_uploadDir = $value;
    }else{
        $this->_error[] = "Thu muc khong hop le";
    }
}

// Phương thức kiểm tra điều kiện upload của tập tin
public function isVail(){
//    $flag = false;
//    if(count($this->_error) > 0){
//        $flag = true;
//    }
    $flag = count(($this->_error)) > 0 ? false : true;
    return $flag;
}

//Phương thức upload tập tin
public function upload($rename = true){
    if($rename == true){
        $fileName    = $this->randomString(6);
        $destination = $this->_uploadDir. $fileName;
    }else{
        $destination = $this->_uploadDir. $this->_fileName;
    }
    @move_uploaded_file($this->_fileTmp,$destination);

    $fileName  = pathinfo($destination, PATHINFO_FILENAME);
 
    //125 x 125
    $thumb = PhpThumbFactory::create($destination);
    $thumb -> resize(125, 125);
    $thumb->save($this->_uploadDir . '125-' . $fileName . '.' . $this->_fileExtension);

     //450 x 450
     $thumb = PhpThumbFactory::create($destination);
     $thumb -> resize(450, 450);
     $thumb->save($this->_uploadDir . '450-' . $fileName . '.' . $this->_fileExtension);

}

//Phương thức hiển thị lỗi 
public function showError(){
    $xhtml = '';
    if(!empty($this->_error)){
        $xhtml = '<ul class="alert alert-danger">';
        foreach ($this->_error as $error){
            $xhtml .= '<li>'. $error .'</li>';
        }
        $xhtml .='</ul>';
    }
    return $xhtml;
}
//Phương thức Random file name 
private function randomString($length = 5){
    $arrCharacter = array_merge(range('A','Z'),range('a','z'),range(0,9));
    $arrCharacter = implode($arrCharacter,'');
    $arrCharacter = str_shuffle($arrCharacter);

    $result       = substr($arrCharacter, 0, $length) . '.' . $this->_fileExtension;
    return  $result;
}
}