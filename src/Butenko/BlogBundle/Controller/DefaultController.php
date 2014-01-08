<?php

namespace Butenko\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Butenko\BlogBundle\Entity\Article;
use Butenko\BlogBundle\Entity\Category;
use Butenko\BlogBundle\Entity\Tag;
use Butenko\BlogBundle\Form\Type\ArticleType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ButenkoBlogBundle:Default:index.html.twig', array('name' => 'sss'));
    }

    public function createAction()
    {
        $category = new Category();
        $category->setName('hell category');

        $tag1 = new Tag();
        $tag1->setName('tag1');

        $tag2 = new Tag();
        $tag2->setName('tag2');

//        $category = $this->getDoctrine()
//            ->getRepository('ButenkoBlogBundle:Category')
//            ->find(1);

        $article = new Article();
        $article->setTitle('Satan Art')
            ->setCategory($category)
            ->addTag($tag1)
            ->addTag($tag2);

        $article1 = new Article();
        $article1->setTitle('Satan Art1')
            ->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($article);
        $em->persist($article1);
        $em->persist($tag1);
        $em->persist($tag2);
        $em->flush();

        return $this->redirect($this->generateUrl('show'));
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

    public function showByTagsAction()
    {
        $tags = $this->getDoctrine()
            ->getRepository('ButenkoBlogBundle:Tag')
            ->findBy(array(
                'name' => 'q'
            ));
        foreach ($tags as $tag) {
            $articleArray = $tag->getArticles();
            foreach ($articleArray as $article) {
                $articles[] = $article;
            }
        }

        return $this->render('ButenkoBlogBundle:Default:index.html.twig', array(
            'articles' => $articles
        ));
    }

    public function newArticleAction(Request $request)
    {
        $category = new Category();
        $tag = new Tag();
        $article = new Article();
        $article->setCategory($category);
        $article->addTag($tag);

        $form = $this->createForm(new ArticleType(), $article);
        $form->handleRequest($request);

        var_dump($form->isValid());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->persist($category);
            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->generateUrl('butenko_blog_show', array(
                'title' => $article->getTitle()
            )));
        }

        return $this->render('ButenkoBlogBundle:Default:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
