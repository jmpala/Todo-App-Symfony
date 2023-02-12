<?php

namespace App\DataFixtures;

use App\Factory\TaskFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tasks = TaskFactory::createMany(10);
        // $product = new Product();
        // $manager->persist($tasks);

        $manager->flush();
    }
}
