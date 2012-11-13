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

// for pagination
use Pagerfanta\Adapter\PropelAdapter;
use Pagerfanta\Pagerfanta;

use Herb\FrontendBundle\model\products;
use Herb\FrontendBundle\model\productsQuery;
use Herb\FrontendBundle\model\productTypeQuery;
use Herb\FrontendBundle\Form\Type\productsType;
use Herb\FrontendBundle\Form\Type\productsEditType;
use Herb\FrontendBundle\Form\Type\productTypeType;


use Herb\MyLib\UploadAndResizeImage;

/**
 * @Route("/aaddmmiinnppaaggee/aanqqggfff/products")
 */
class ProductsController extends Controller
{
    private $allow_images_type;
    private $allow_images_size;
    private $upload_dir;

    private $maxPerPage;

    // set upload image variable
    public function __construct()
    {
        $this->allow_images_type = array("image/jpeg", "image/png", "image/gif");
        $this->allow_images_size = 20;
        $this->upload_dir = "products/";

        $this->maxPerPage = 20;
    }

    /**
     * @Route("/", defaults={"page" = 0})
     * @Route("/{page}", name="adminProducts", defaults={"page" = 0}, requirements={"page" = "\d+"})
     * @Template()
     */
    public function productsAction($page)
    {
        
        if ($page == 0) {
            return $this->redirect($this->generateUrl("adminProducts")."/1");
        }
        $products = productsQuery::create()
                    ->orderByprodId();
        $adapter = new PropelAdapter($products);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage($this->maxPerPage); // 10 by default
        $pagerfanta->setCurrentPage($page); // 1 by default
        
        return array(
                    'thePager' => $pagerfanta,
                    'products' => $pagerfanta->getCurrentPageResults()
                );


    }

    /**
     * @Route("/new", name="newProducts")
     * @Template()
     */
    public function newProductsAction()
    {

        $product = new products();

        $product_catgorys = productTypeQuery::create()
                            ->orderByptId()
                            ->find();
        $formOption = array();
        
        $temp = $product_catgorys->toArray();
        $catgorys = array();
        for($i = 0; $i<count($temp); $i++){
            $catgorys[ $temp[$i]['ptId'] ] = $temp[$i]['ptName'];
        }
        $formOption['catgorys'] = $catgorys;
        $formOption['catgory_default'] = $product->getprodCatgory();

        $form = $this->createForm(new productsType, $product, $formOption);

        $request = $this->getRequest();
        if($request->isMethod("POST")){
            $form->bind($request);
            

            if($form->isValid()){
                
                $fileRequest = $request->files->get("products", null);
                if( !is_null($fileRequest) ){
                    $file = $fileRequest['prodPic'];
                    
                    // set the new images width to 752
                    $new_width = 192;
                    $new_height = 0;

                    $uploadAndResize = new UploadAndResizeImage($this->allow_images_type, $this->allow_images_size, $this->upload_dir);
                    
                    list($newFileName, $hasError, $errorMsg) = $uploadAndResize->handleUploadImage($file, $new_width, $new_height);
                    if (!$hasError) {
                        $product->setprodPic($newFileName);
                    }
                    
                }else{
                    $hasError = true;
                    $errorMsg[] = "一定要上傳張照片！";
                }

                if(!$hasError){
                    $product->save();    
                    return $this->redirect($this->generateUrl("adminProducts"));
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
     * @Route("/edit/{id}", name="editProducts", defaults={"id" = 0}, requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction($id)
    {
        if ($id == 0) {
            return $this->redirect($this->generateUrl("adminProducts"), 301);
        }
        $hasError = false;
        $request = $this->getRequest();

        $product = productsQuery::create()
                    ->findpk($id);
        $originName = $product->getprodPic();

        $product_catgorys = productTypeQuery::create()
                            ->orderByptId()
                            ->find();
        $formOption = array();
        
        $temp = $product_catgorys->toArray();
        $catgorys = array();
        for($i = 0; $i<count($temp); $i++){
            $catgorys[ $temp[$i]['ptId'] ] = $temp[$i]['ptName'];
        }
        $formOption['catgorys'] = $catgorys;
        $formOption['catgory_default'] = $product->getprodCatgory();
        
        $form = $this->createForm(new productsEditType, $product, $formOption);

        // var_dump($form);
        // $form->add('prodCatgory', 'model', array(
        //                                         'class' => 'Herb\FrontendBundle\Model\productType',
        //                                         'property'  => 'ptName',
        //                                         'data' => 2));
        // check POST
        if($request->isMethod("POST")){
            // bind the POST values to the form
            $form->bind($request);

            // check the form data is valid
            if($form->isValid()){
                // get upload file
                $fileRequest = $request->files->get("products", null);
                $file = $fileRequest['prodPic'];
                // check have uploaded file
                if( !is_null($file) ){
                    // set the new images width to 192
                    $new_width = 192;
                    $new_height = 0;

                    $uploadAndResize = new UploadAndResizeImage($this->allow_images_type, $this->allow_images_size, $this->upload_dir);
                    
                    // upload image
                    list($newFileName, $hasError, $errorMsg) = $uploadAndResize->handleUploadImage($file, $new_width, $new_height);
                    if (!$hasError) {
                        unlink( __DIR__."/../../../../web/".$this->upload_dir.$originName );
                        $product->setprodPic($newFileName);
                    }else{
                        $product->setprodPic($originName);
                    }
                    
                }else{
                    $product->setprodPic($originName);
                }

                if(!$hasError){
                    
                    $product->save();    
                    return $this->redirect($this->generateUrl("adminProducts"));
                }else{
                    return array(
                        "product" => $product,
                        "form" => $form->createView(),
                        "id" => $id,
                        "uploadErrorMsg" => implode("<br>", $errorMsg),
                    );
                }

                
            }
            
        }

        return array(
            "product" => $product,
            "form" => $form->createView(),
            "id" => $id,
            "uploadErrorMsg" => "",
        );
    }

    /**
     * @Route("/delete", defaults={"id" = 0})
     * @Route("/delete/{id}", name="deleteProducts", defaults={"id" = 0}, requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction($id)
    {
        if ($id == 0) {
            return $this->redirect($this->generateUrl("adminProducts"), 301);
        }

        $product = productsQuery::create()
                ->findPK($id);
        if (unlink( __DIR__."/../../../../web/".$this->upload_dir.$product->getprodPic() )) {
            $product->delete();   
            return $this->redirect($this->generateUrl("adminProducts"));
        }else{
            return new Response('<script>alert("刪除失敗!!");location.href="'.$this->generateUrl("adminProducts").'"</script>');
        }
        

        
    }


}
