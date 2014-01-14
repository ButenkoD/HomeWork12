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
use Butenko\BlogBundle\Entity\Category;
use Symfony\Component\Yaml\Yaml;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = Yaml::parse($this->getCategoryFile());
        foreach($categories as $category){
            $categoryObject = new Category();
            $categoryObject->setName($category['name']);
            $this->setReference(array_search($category, $categories), $categoryObject);
            $manager->persist($categoryObject);
        }
        $manager->flush();
    }

    public function getCategoryFile()
    {
        return __DIR__.'/../data/category.yml';
    }

    public function getOrder()
    {
        return 2;
    }
} 