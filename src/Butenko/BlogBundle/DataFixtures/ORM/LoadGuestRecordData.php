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
use Butenko\BlogBundle\Entity\GuestRecord;
use Symfony\Component\Yaml\Yaml;

class LoadGuestRecordData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $guestRecords = Yaml::parse($this->getPostFile());
        foreach($guestRecords['records'] as $guestRecord){
            $guestRecordObject = new GuestRecord();
            $guestRecordObject->setName($guestRecord['name'])
                ->setEmail($guestRecord['email'])
                ->setText($guestRecord['text']);
        $manager->persist($guestRecordObject);
        }

        $manager->flush();
    }

    public function getPostFile()
    {
        return __DIR__.'/../data/guestrecords.yml';
    }

    public function getOrder()
    {
        return 1;
    }
} 