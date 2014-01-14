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

    public function createArticleAction(Request $request)
    {
//        $category = new Category();
        $tag = new Tag();
        $article = new Article();
//        $article->setCategory($category);
        $article->addTag($tag);

        $form = $this->createForm(new ArticleType(), $article);
        $form->handleRequest($request);

        var_dump($form->isValid());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
//            $em->persist($category);
            $em->persist($tag);
            $em->flush();

            return $this->redirect($this->generateUrl('butenko_blog_show_article', array(
                'title' => $article->getTitle()
            )));
        }

        return $this->render('ButenkoBlogBundle:Default:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function showArticleAction($title)
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

}
