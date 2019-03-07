<?php

namespace App\DataFixtures;

use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PlaneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository('App:Company')->findAll();

        for ($i = 0; $i < 15; $i++) {
            $plane = new Plane();
            $plane->setModel('Airbus '.$faker->randomNumber(3));
            $plane->setCompany($companies[mt_rand(0,count($companies)-1)]);
            $plane->setDateCommissioning($faker->dateTimeBetween('-30 years', '-2 years'));
            $plane->setSeatNumber($faker->numberBetween(1, 100));
            $manager->persist($plane);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CompanyFixtures::class,
        );
    }
}