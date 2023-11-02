<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $property = new Property();

            $property->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setRooms(rand(1, 5))
                ->setSurface(rand(100, 500))
                ->setBedrooms(rand(1, 5))
                ->setFloor(rand(1, 5))
                ->setPrice(rand(1000, 5000))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode(rand(101, 103))
                ->setImage("https://blog.hubspot.fr/hs-fs/hubfs/media/marketingimmobilier.jpeg?width=610&height=406&name=marketingimmobilier.jpeg")
                ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
