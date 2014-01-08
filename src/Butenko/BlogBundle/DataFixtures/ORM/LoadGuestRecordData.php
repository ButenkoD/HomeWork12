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
        $records = Yaml::parse($this->getPostFile());
        foreach($records['records'] as $record){
            $guestRecord = new GuestRecord();
            $guestRecord->setName($record['name'])
                ->setEmail($record['email'])
                ->setText($record['text']);
        $manager->persist($guestRecord);
        }

        $manager->flush();
    }

    public function getPostFile()
    {
        return __DIR__.'/../data/guestrecords.yml';
    }
} 