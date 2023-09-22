<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 150; $i++) {
            $category = $this->getReference('categoryShop-' . $faker->numberBetween(1, 6));
            $user = new Product();
            $user->setTitle($faker->sentence);
            $user->setSlug($faker->slug);
            $user->setDescription($faker->text);
            $user->setIsOnline(true);
            $user->setSubtitle($faker->text(155));
            $user->setPrice($faker->randomFloat(2));
            $user->setImage($faker->imageUrl(640, 480, 'animals', true));
            $user->setCreatedAt(new \DateTime());
            $user->setCategory($category);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
