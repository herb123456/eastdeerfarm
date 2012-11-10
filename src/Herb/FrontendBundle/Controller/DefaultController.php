<?php

namespace Herb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pagerfanta\Adapter\PropelAdapter;
use Pagerfanta\Pagerfanta;

use Herb\FrontendBundle\model\indexPicQuery;
use Herb\FrontendBundle\model\productsQuery;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        //get index pic
        $indexpics = indexPicQuery::create()
                    ->orderByIpId()
                    ->find();
            

        if ($indexpics) {
            
        }       
        return array('indexPics' => $indexpics);
    }

    /**
     * @Route("/products", defaults={"page" = 0})
     * @Route("/products/{page}", name="products", defaults={"page" = 1}, requirements={"page" = "\d+"} )
     * @Template()
     */
    public function productsAction($page)
    {
        if ($page == 0) {
            
            return $this->redirect($this->generateUrl("products")."/1");
        }

        $maxPerPage = 6;

        $products = productsQuery::create();
        $adapter = new PropelAdapter($products);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage($maxPerPage); // 10 by default
        $pagerfanta->setCurrentPage($page); // 1 by default
        
        return array(
                    'thePager' => $pagerfanta,
                    'result' => $pagerfanta->getCurrentPageResults()
                );
    }

    /**
     * @Route("/pdeffect", name="pdeff", defaults={"effid" = 1}, requirements={"effid" = "\d+"})
     * @Route("/pdeffect/{effid}", defaults={"effid" = 1}, requirements={"effid" = "\d+"})
     * @Template()
     */
    public function productEffectAction($effid)
    {
        if ($effid > 0 && $effid < 6) {
            return $this->render("HerbFrontendBundle:Default:productEffect_".$effid.".html.twig");
        } else {
            throw $this->createNotFoundException('The effect does not exist');
        }
        
        
    }

    /**
     * @Route("/live", name="live")
     * @Template()
     */
    public function liveAction()
    {
        
    }

    /**
     * @Route("/map", name="map")
     * @Template()
     */
    public function mapAction()
    {
        
    }



}
