<?php

namespace App\DataFixtures;

use App\Entity\Personnal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PersonnalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');
        $functions = ['Pilot', 'Copilot', 'Hostess'];

        $companies = $manager->getRepository('App:Company')->findAll();
        $flights = $manager->getRepository('App:Flight')->findAll();

        for ($i = 0; $i < 10; $i++) {
            $personnal = new Personnal();
            $personnal->setName($faker->name);
            $personnal->setCompany($companies[mt_rand(0, count($companies)-1)]);
            $personnal->setFunction($functions[mt_rand(0,3)]);

            $personnal->addFlight($flights[mt_rand(0, count($flights) - 1)]);

            $manager->persist($personnal);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CompanyFixtures::class,
            FlightFixtures::class
        );
    }
}