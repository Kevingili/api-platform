<?php

namespace App\DataFixtures;

use App\Entity\Luggage;
use App\Entity\Passenger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LuggageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $passengers = $manager->getRepository('App:Passenger')->findAll();

        for($i=0 ; $i<20; $i++){

            $luggage = new Luggage();
            $luggage->setWeight(mt_rand(2,20));
            $luggage->setPassenger($passengers[$i]);

            $manager->persist($luggage);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(PassengerFixtures::class);
    }

}
