<?php

namespace App\DataFixtures;

use App\Entity\Passenger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PassengerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $flights = $manager->getRepository('App:Flight')->findAll();

        for ($i = 0; $i < 30; $i++) {
            $passenger = new Passenger();
            $passenger->setLastname($faker->lastName);
            $passenger->setFirstname($faker->firstName);
            $passenger->setBirthdate($faker->dateTimeBetween('-30 years', '-2 years'));
            # $passenger->setFlight($faker->);
            $passenger->setGender($faker->randomElement($array = array('male', 'female')));
            $passenger->setFlight($flights[rand(0, count($flights) - 1)]);

            $manager->persist($passenger);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(FlightFixtures::class);
    }
}

