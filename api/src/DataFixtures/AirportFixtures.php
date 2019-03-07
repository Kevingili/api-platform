<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AirportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $cities = $manager->getRepository('App:City')->findAll();

        for($i = 0; $i < 10; $i++){
            $airport = new Airport();
            $airport->setName('Airport'.$cities[$i]->getName());
            $airport->setCity($cities[$i]);
            $manager->persist($airport);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return array(CityFixtures::class);
    }
}
