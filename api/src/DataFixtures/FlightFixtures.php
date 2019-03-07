<?php

namespace App\DataFixtures;

use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FlightFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $airports = $manager->getRepository('App:Airport')->findAll();
        $planes = $manager->getRepository('App:Plane')->findAll();

        for ($i = 0; $i < 5; $i++) {
            $flight = new Flight();
            $flight->setDepartureAirport($airports[rand(0, count($airports)-1)]);
            $flight->setArrivalAirport($airports[rand(0, count($airports)-1)]);
            $flight->setDepartureDate($faker->dateTimeInInterval('now', '+1 day'));
            $flight->setArrivalDate($faker->dateTimeInInterval('+1 day', '+2 days'));
            $flight->setNumber($faker->randomNumber(6, true));
            $flight->setPlane($planes[mt_rand(0,4)]);

            $manager->persist($flight);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            AirportFixtures::class,
            PlaneFixtures::class,
        );
    }
}