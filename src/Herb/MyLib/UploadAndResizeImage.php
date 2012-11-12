<?php

namespace Herb\MyLib;

class UploadAndResizeImage
{
	private $allow_images_type;

    private $allow_images_size;

    private $upload_dir;

    public function __construct($allow_type = array("image/jpeg", "image/png", "image/gif"), $allow_size = 20, $upload_dir)
    {
        $this->allow_images_type = $allow_type;
        $this->allow_images_size = 1024 * 1024 * $allow_size;
        $this->upload_dir = __DIR__."/../../../web/".$upload_dir;
    }

    public function handleUploadImage($file, $new_width, $new_height){
        // return array
        // 0 => new file name
        // 1 => has error
        // 2 => error message
        $errorMsg = array();
        $result = array("", false, array());

        // get image info
        $uploadedFile = $file->getpathName();
        $imageInfo = getimagesize($uploadedFile);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo['mime'];
        $size = $file->getClientsize();

        // check file type
        if (!$this->checkFileType($type)) {
            $errorMsg[] = "只支援上傳" . str_replace("image/", "", implode(",", $this->allow_images_type));
            $result[1] = true;
        }

        // check file size
        if (!$this->checkFileSize($size)) {
            $errorMsg[] = "檔案大小限製為" . $this->allow_images_size / 1024 / 1024 ."MB 以內喔！";
            $result[1] = true;
        }

        // check is width > height
        // if ($height > $width) {
        //     $errorMsg[] = "首頁相片使用長方形會比較好看喔！";
        //     $result[1] = true;
        // }

        if( $result[1] ){
            $result[2] = $errorMsg;

            return $result;
        }else{
            $newFileName = $this->doUpload($imageInfo, $uploadedFile, $new_width, $new_height);
            if( $newFileName !== false){
                $result[0] = $newFileName;
            }else{
                $result[1] = true;
                $errorMsg[] = "檔案上傳失敗!!";
                $result[2] = $errorMsg;
            }

            return $result;
        }


    }

    public function checkFileType($type){
        // file type validate
        if(!in_array($type, $this->allow_images_type)){
            return false;
        }else{
            return true;
        }
    }

    public function checkFileSize($size){
        // file size validate
        if ($size > $this->allow_images_size) {
            return false;
        }else{
            return true;
        }
    }

    public function doUpload($imageInfo, $uploadedFile, $new_width, $new_height){
        // $width = $imageInfo[0];
        // $height = $imageInfo[1];
        // $type = $imageInfo['mime'];
        // file rename
        // $originName = $file->getoriginalName();
        $ext = false;
        $newName = md5(time().md5(time()));

        if($new_width !== 0 || $new_height !== 0){
        	// image resize and save
	        $ext = $this->doResize($new_width, $new_height, $uploadedFile, $this->upload_dir.$newName);
		}else{
			// just upload
		}
        
        if($ext !== false){
            // return file name
            return $newName.$ext;    
        }else{
            return false;
        }
        
    }

    public function doResize($new_image_width, $new_image_height, $old_image_path, $new_image_path){
        $imageInfo = getimagesize($old_image_path);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo['mime'];

        switch($type){
            case "image/jpeg":
                $im = imagecreatefromjpeg($old_image_path); //jpeg file
                $extention = ".jpg";
                break;
            case "image/gif":
                $im = imagecreatefromgif($old_image_path); //gif file
                $extention = ".gif";
                break;
            case "image/png":
                $im = imagecreatefrompng($old_image_path); //png file
                $extention = ".png";
                break;
            default: 
                return false;
        }

        // caculate new size
        if ($new_image_width === 0) {
        	$new_image_width = $width * ( $new_image_height / $height );
        }else if($new_image_height === 0){
        	$new_image_height = $height * ( $new_image_width / $width );
        }else if($new_image_width === 0 && $new_image_height === 0){
        	return false;
        }
        // $new_width = 752;
        // $proportion = $new_width / $image_width;
        // $new_height = $image_height * $proportion;

        // create new image
        $new_im = imagecreatetruecolor($new_image_width, $new_image_height);
        imagecopyresized($new_im, $im, 0, 0, 0, 0, $new_image_width, $new_image_height, $width, $height);

        // save image
        $new_image_path = $new_image_path . $extention;
        switch($type){
            case "image/jpeg":
                imagejpeg($new_im, $new_image_path);
                break;
            case "image/gif":
                imagegif($new_im, $new_image_path);
                break;
            case "image/png":
                imagepng($new_im, $new_image_path);
                break;
            default: 
                return false;
        }

        return $extention;
    }
}