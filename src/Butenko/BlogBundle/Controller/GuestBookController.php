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
        $guestRecord = new GuestRecord();
        $form = $this->createForm(new GuestRecordType(), $guestRecord);
        $form->handleRequest($request);

        $em = $this->getDoctrine()
            ->getManager();

        if ($form->isValid()) {
            $em->persist($guestRecord);
            $em->flush();

            return $this->redirect($this->generateUrl('butenko_guest_book'));
        }

        $query = $em->createQuery('SELECT g FROM ButenkoBlogBundle:GuestRecord g ORDER BY g.published DESC, g.id DESC ');

        $paginator  = $this->get('knp_paginator');
        $guestRecords = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $this->container->getParameter('guest_records_per_page')
        );

        return $this->render('ButenkoBlogBundle:GuestBook:index.html.twig', array(
            'form' => $form->createView(),
            'guestRecords' => $guestRecords,
        ));
    }

    public function showAction($slug)
    {
        $guestRecord = $this->getDoctrine()
            ->getRepository('ButenkoBlogBundle:GuestRecord')
            ->findOneBy(array('slug' => $slug));

        return $this->render('ButenkoBlogBundle:GuestBook:show.html.twig', array(
            'guestRecord' => $guestRecord
        ));
    }

    public function removeAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('ButenkoBlogBundle:GuestRecord')
            ->findOneBy(array('slug' => $slug));
        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('butenko_guest_book'));
    }
}
