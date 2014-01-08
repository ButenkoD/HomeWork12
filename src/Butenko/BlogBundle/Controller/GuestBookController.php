<?php

namespace Butenko\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Butenko\BlogBundle\Entity\GuestRecord;
use Butenko\BlogBundle\Form\Type\GuestRecordType;
use Symfony\Component\HttpFoundation\Request;

class GuestBookController extends Controller
{
    public function indexAction(Request $request)
    {
        $guestrecord = new GuestRecord();
        $form = $this->createForm(new GuestRecordType(), $guestrecord);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($guestrecord);
            $em->flush();

            return $this->redirect($this->generateUrl('butenko_guest_book'));
        }

        return $this->render('ButenkoBlogBundle:GuestBook:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function showAction($title)
    {
        $articles[] = $this->getDoctrine()
            ->getRepository('ButenkoBlogBundle:Article')
            ->findOneBy(array(
                'title' => $title
            ));

        return $this->render('ButenkoBlogBundle:Default:index.html.twig', array(
            'articles' => $articles
        ));

    }
}
