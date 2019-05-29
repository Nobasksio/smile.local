<?php

namespace App\DataFixtures;

use App\Entity\MapPlace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $MapPlace = new MapPlace();
            $MapPlace->setFloor(1);
            $manager->persist($MapPlace);
        }
        for ($i = 0; $i < 20; $i++) {
            $MapPlace = new MapPlace();
            $MapPlace->setFloor(2);
            $manager->persist($MapPlace);
        }


        $manager->flush();
    }
}
