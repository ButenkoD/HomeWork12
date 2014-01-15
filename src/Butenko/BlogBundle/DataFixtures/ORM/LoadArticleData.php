<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 1/8/14
 * Time: 9:31 PM
 */

namespace Butenko\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Butenko\BlogBundle\Entity\Article;
use Butenko\BlogBundle\Entity\Tag;
use Symfony\Component\Yaml\Yaml;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $articles = Yaml::parse($this->getArticleFile());

        foreach($articles['articles'] as $article){
            $articleObject = new Article();
            $articleObject->setTitle($article['title'])
                ->setCategory($this->getReference($article['category']))
                ->setViewsNumber($article['viewsNumber']);
            $articleObject->setContent($article['content']);
            foreach($article['tag'] as $tag){
                $articleObject->addTag($this->getReference($tag));
            }

        $manager->persist($articleObject);
        }

        $manager->flush();
    }

    public function getArticleFile()
    {
        return __DIR__.'/../data/article.yml';
    }

    public function getOrder()
    {
        return 4;
    }
} 