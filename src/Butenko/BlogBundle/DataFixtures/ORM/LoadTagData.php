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
use Butenko\BlogBundle\Entity\Tag;
use Symfony\Component\Yaml\Yaml;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tags = Yaml::parse($this->getTagFile());
        foreach($tags as $tag){
            $tagObject = new Tag();
            $tagObject->setName($tag['name']);
            $this->setReference(array_search($tag, $tags), $tagObject);
            $manager->persist($tagObject);
        }
        $manager->flush();
    }

    public function getTagFile()
    {
        return __DIR__.'/../data/tag.yml';
    }

    public function getOrder()
    {
        return 3;
    }
} 