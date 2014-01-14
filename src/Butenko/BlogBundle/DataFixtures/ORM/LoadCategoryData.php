<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 1/8/14
 * Time: 9:31 PM
 */

namespace Butenko\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Butenko\BlogBundle\Entity\Category;
use Symfony\Component\Yaml\Yaml;

class LoadCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = Yaml::parse($this->getPostFile());
        foreach($categories as $category){
            $categoryObject = new Category();
            $categoryObject->setName($category['name']);
            $manager->persist($categoryObject);
        }
        $manager->flush();
    }

    public function getPostFile()
    {
        return __DIR__.'/../data/category.yml';
    }
} 