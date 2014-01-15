<?php

namespace Butenko\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Butenko\BlogBundle\Entity\Article;
use Butenko\BlogBundle\Entity\Tag;
use Butenko\BlogBundle\Form\Type\ArticleType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT a FROM ButenkoBlogBundle:Article a ORDER BY a.id DESC ');

        $paginator  = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $this->container->getParameter('articles_per_page')
        );

        return $this->render('ButenkoBlogBundle:Default:blog.html.twig', array(
            'articles' => $articles
        ));
    }

    public function createArticleAction(Request $request)
    {
//        $category = new Category();
        $tag = new Tag();
        $article = new Article();
//        $article->setCategory($category);
        $article->addTag($tag);

        $form = $this->createForm(new ArticleType(), $article);
        $form->handleRequest($request);

//        var_dump($form->isValid());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
//            $em->persist($category);
            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->generateUrl('butenko_blog_show_article', array(
                'slug' => $article->getSlug()
            )));
        }

        return $this->render('ButenkoBlogBundle:Default:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function showArticleAction($slug)
    {
        $article = $this->getDoctrine()
            ->getRepository('ButenkoBlogBundle:Article')
            ->findOneBy(array(
                'slug' => $slug
            ));

        $article->setViewsNumber($article->getViewsNumber()+1);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('ButenkoBlogBundle:Default:article.html.twig', array(
            'article' => $article
        ));
    }

    public function lastArticlesAction()
    {
        $query = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT a FROM ButenkoBlogBundle:Article a ORDER BY a.published DESC')
            ->setMaxResults($this->container->getParameter('last_articles'))
        ;

        return $this->render('ButenkoBlogBundle:Default:lastArticle.html.twig', array(
            'articles' => $query->getResult()
        ));
    }

    public function mostViewedArticlesAction()
    {
        $query = $this->getDoctrine()
            ->getManager()
//            ->createQuery('SELECT a FROM ButenkoBlogBundle:GuestRecord a ORDER BY a.viewsNumber ')
            ->createQuery('SELECT a FROM ButenkoBlogBundle:Article a ORDER BY a.viewsNumber DESC')
            ->setMaxResults($this->container->getParameter('most_viewed_articles'))
        ;

        return $this->render('ButenkoBlogBundle:Default:lastArticle.html.twig', array(
            'articles' => $query->getResult()
        ));
    }

    public function lastGuestRecordsAction()
    {
        $query = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT p FROM ButenkoBlogBundle:GuestRecord p ORDER BY p.published DESC, p.id DESC')
            ->setMaxResults($this->container->getParameter('last_guest_records'))
        ;

        return $this->render('ButenkoBlogBundle:Default:lastGuestRecord.html.twig', array(
            'records' => $query->getResult()
        ));
    }

    public function showByCategoryAction($id)
    {
        $category = $this->getDoctrine()
            ->getRepository('ButenkoBlogBundle:Category')
            ->findOneBy(array('id' => $id));
        $articles = $category->getArticles();

        return $this->render('ButenkoBlogBundle:Default:showBy.html.twig', array(
            'articles' => $articles
        ));
    }

    public function showByTagAction($id)
    {
        $tag = $this->getDoctrine()
            ->getRepository('ButenkoBlogBundle:Tag')
            ->findOneBy(array('id' => $id));
        $articles = $tag->getArticles();

        return $this->render('ButenkoBlogBundle:Default:showBy.html.twig', array(
            'articles' => $articles
        ));
    }

    public function aboutMeAction()
    {
        return $this->render('ButenkoBlogBundle:Default:aboutMe.html.twig');
    }
}
