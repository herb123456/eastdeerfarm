<?php

namespace Herb\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

// for pagination
use Pagerfanta\Adapter\PropelAdapter;
use Pagerfanta\Pagerfanta;

// for book query
use Herb\FrontendBundle\Model\book;
use Herb\FrontendBundle\Model\bookQuery;

use Herb\GuestBookBundle\Form\BookType;

class DefaultController extends Controller
{
    /**
     * @Route("/", defaults={"page" = 0})
     * @Route("/{page}", name="book", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Template()
     */
    public function bookAction($page)
    {
        $maxPerPage = 6;

        $books = bookQuery::create()
                 ->orderBybookId("desc");
        $adapter = new PropelAdapter($books);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage($maxPerPage); // 10 by default
        $pagerfanta->setCurrentPage($page); // 1 by default
        
        return array(
                    'thePager' => $pagerfanta,
                    'result' => $pagerfanta->getCurrentPageResults()
                );
    }

    /**
     * @Route("/sendmsg", name="sendmsg")
     * @Template()
     */
    public function sendMsgAction()
    {
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);

        
        return array('form' => $form->createView());
    }

    /**
     * @Route("/sendTo", name="sendto")
     * @Template()
     */
    public function sendToAction()
    {
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            // var_dump($form->getErrors());
            if ($form->isValid()) {
                $book->save();
                
                return new Response('<script>alert("留言成功！");location.href="'.$this->generateUrl("book").'";</script>');
            }else{
                return $this->redirect($this->generateUrl('book'));
            }
        }
        //echo "nothing";
        return $this->redirect($this->generateUrl("book"));
    }
}
