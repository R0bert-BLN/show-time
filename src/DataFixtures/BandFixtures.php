<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Enum\MusicGenre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BandFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $band = new Band();
            $band->setName($faker->unique()->company());
            $band->setDescription($faker->paragraph());
            $band->setPicture($faker->imageUrl());
            $band->setSlug($faker->unique()->slug());
            $band->setGenre($faker->randomElement(MusicGenre::getAllGenres()));

            $manager->persist($band);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['festivals'];
    }
}
