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
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
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
                ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
