<?php

namespace App\DataFixtures;

use App\Entity\Festival;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FestivalFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 2; $i++) {
            $location = new Location();

            $location->setName($faker->name());
            $location->setCity($faker->city());
            $location->setCountry($faker->country());

            $manager->persist($location);

            $festival = new Festival();

            $festival->setName($faker->company());
            $festival->setDescription($faker->text());
            $festival->setPicture($faker->imageUrl());
            $festival->setSlug($faker->slug());
            $festival->setStartDate($faker->dateTime());
            $festival->setEndDate($faker->dateTime());
            $festival->setLocation($location);

            $manager->persist($festival);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['festivals'];
    }
}
