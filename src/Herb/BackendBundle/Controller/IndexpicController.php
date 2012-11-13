<?php

namespace Herb\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Herb\FrontendBundle\model\indexPic;
use Herb\FrontendBundle\model\indexPicQuery;
use Herb\FrontendBundle\Form\Type\indexPicType;
use Herb\FrontendBundle\Form\Type\indexPicEditType;


use Herb\MyLib\UploadAndResizeImage;
/**
 * @Route("/aaddmmiinnppaaggee/aanqqggfff/indexpic")
 */
class IndexpicController extends Controller
{
    private $allow_images_type;
    private $allow_images_size;
    private $upload_dir;

    // set upload image variable
    public function __construct()
    {
        $this->allow_images_type = array("image/jpeg", "image/png", "image/gif");
        $this->allow_images_size = 20;
        $this->upload_dir = "indexPic/";
    }

    /**
     * @Route("/", name="adminIndexpic")
     * @Template()
     */
    public function indexpicAction()
    {
        $pics = indexPicQuery::create()
                ->orderByipId()
                ->find();

        return array(
            "pics" => $pics,
        );
    }

    /**
     * @Route("/new", name="newIndexpic")
     * @Template()
     */
    public function newIndexpicAction()
    {

        $pic = new indexPic();

        $form = $this->createForm(new indexPicType, $pic);

        $request = $this->getRequest();
        if($request->isMethod("POST")){
            $form->bind($request);
            

            if($form->isValid()){
                
                $fileRequest = $request->files->get("indexpic", null);
                if( !is_null($fileRequest) ){
                    $file = $fileRequest['ipFilename'];
                    
                    // set the new images width to 752
                    $new_width = 752;
                    $new_height = 0;

                    $uploadAndResize = new UploadAndResizeImage($this->allow_images_type, $this->allow_images_size, $this->upload_dir);
                    
                    // check width > height
                    $imageInfo = getimagesize($file);
                    $width = $imageInfo[0];
                    $height = $imageInfo[1];
                    if ($height > $width) {
                        $errorMsg[] = "首頁相片使用長方形會比較好看喔！";
                        
                        return array(
                            "form" => $form->createView(),
                            "uploadErrorMsg" => implode("<br>", $errorMsg),
                        );
                    }

                    list($newFileName, $hasError, $errorMsg) = $uploadAndResize->handleUploadImage($file, $new_width, $new_height);
                    if (!$hasError) {
                        $pic->setipFilename($newFileName);
                    }
                    
                }else{
                    $hasError = true;
                    $errorMsg[] = "一定要上傳張照片！";
                }

                if(!$hasError){
                    $pic->save();    
                    return $this->redirect($this->generateUrl("adminIndexpic"));
                }else{
                    return array(
                        "form" => $form->createView(),
                        "uploadErrorMsg" => implode("<br>", $errorMsg),
                    );
                }

                
            }
            
        }

        return array("form" => $form->createView(),
                     "uploadErrorMsg" => "",);
    }


    /**
     * @Route("/edit", defaults={"id" = 0})
     * @Route("/edit/{id}", name="editIndexpic", defaults={"id" = 0}, requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction($id)
    {
        if ($id == 0) {
            return $this->redirect($this->generateUrl("adminIndexpic"), 301);
        }
        $hasError = false;
        $request = $this->getRequest();

        $pic = indexPicQuery::create()
                ->findpk($id);
        $originName = $pic->getipFilename();

        $form = $this->createForm(new indexPicEditType, $pic);

        // check POST
        if($request->isMethod("POST")){
            // bind the POST values to the form
            $form->bind($request);

            // check the form data is valid
            if($form->isValid()){
                // get upload file
                $fileRequest = $request->files->get("indexpic", null);
                $file = $fileRequest['ipFilename'];
                // check have uploaded file
                if( !is_null($file) ){
                    // set the new images width to 752
                    $new_width = 752;
                    $new_height = 0;

                    $uploadAndResize = new UploadAndResizeImage($this->allow_images_type, $this->allow_images_size, $this->upload_dir);
                    
                    // check width > height
                    $imageInfo = getimagesize($file);
                    $width = $imageInfo[0];
                    $height = $imageInfo[1];
                    if ($height > $width) {
                        $errorMsg[] = "首頁相片使用長方形會比較好看喔！";
                        $pic->setipFilename($originName);

                        return array(
                            "pic" => $pic,
                            "form" => $form->createView(),
                            "id" => $id,
                            "uploadErrorMsg" => implode("<br>", $errorMsg),
                        );
                    }

                    // upload image
                    list($newFileName, $hasError, $errorMsg) = $uploadAndResize->handleUploadImage($file, $new_width, $new_height);
                    if (!$hasError) {
                        unlink( __DIR__."/../../../../web/".$this->upload_dir.$originName );
                        $pic->setipFilename($newFileName);
                    }else{
                        $pic->setipFilename($originName);
                    }
                    
                }else{
                    $pic->setipFilename($originName);
                }

                if(!$hasError){
                    $pic->save();    
                    return $this->redirect($this->generateUrl("adminIndexpic"));
                }else{
                    return array(
                        "pic" => $pic,
                        "form" => $form->createView(),
                        "id" => $id,
                        "uploadErrorMsg" => implode("<br>", $errorMsg),
                    );
                }

                
            }
            
        }

        return array(
            "pic" => $pic,
            "form" => $form->createView(),
            "id" => $id,
            "uploadErrorMsg" => "",
        );
    }

    /**
     * @Route("/delete", defaults={"id" = 0})
     * @Route("/delete/{id}", name="deleteIndexpic", defaults={"id" = 0}, requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction($id)
    {
        if ($id == 0) {
            return $this->redirect($this->generateUrl("adminIndexpic"), 301);
        }

        $pic = indexPicQuery::create()
                ->findPK($id);
        if (unlink( __DIR__."/../../../../web/".$this->upload_dir.$pic->getipFilename() )) {
            $pic->delete();   
            return $this->redirect($this->generateUrl("adminIndexpic"));
        }else{
            return new Response('<script>alert("刪除失敗!!");location.href="'.$this->generateUrl("adminIndexpic").'"</script>');
        }
        

        
    }


}
