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

use Herb\GuestBookBundle\Form\BookAnswerType;

/**
 * @Route("/aaddmmiinnppaaggee/aanqqggfff/guestBook")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", defaults={"page" = 0})
     * @Route("/{page}", name="adminbook", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Template()
     */
    public function adminBookAction($page)
    {
        if ($page == 0) {
            return $this->redirect($this->generateUrl('adminbook')."/1");
        }
        $maxPerPage = 6;

        $books = bookQuery::create()
                 ->orderBybookId("desc");
        $adapter = new PropelAdapter($books);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage($maxPerPage); // 10 by default
        $pagerfanta->setCurrentPage($page); // 1 by default
        
        return array(
                    'thePager' => $pagerfanta,
                    'books' => $pagerfanta->getCurrentPageResults()
                );
    }

    /**
     * @Route("/answerBook/{id}", name="answerBook", defaults={"id" = 0}, requirements={"id" = "\d+"})
     * @Template()
     */
    public function answerBookAction($id)
    {
        if ($id === 0) {
            return $this->redirect($this->generateUrl('adminIndex'));
        }

        $book = bookQuery::create()
                ->findPK($id);
        $form = $this->createForm(new BookAnswerType(), $book);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            // var_dump($form->getErrors());
            if ($form->isValid()) {
                $book->save();
                
                return new Response('<script>alert("回復成功！");location.href="'.$this->generateUrl("adminbook").'";</script>');
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form->createView(),
            'book' => $book,
        );
    }

    /**
     * @Route("/delete/{id}", name="deleteBook", defaults={"id" = 0}, requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction($id)
    {
        $book = bookQuery::create()
                ->findPK($id)
                ->delete();

        return $this->redirect($this->generateUrl('adminbook'));
    }
}
