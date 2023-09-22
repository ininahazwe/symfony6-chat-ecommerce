<?php

namespace App\DataFixtures;

use App\Entity\CategoryShop;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CategoryShopFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $c = [
                1 => [
                        'name' => 'Robes',
                        'slug' => 'robes',
                ],

                2 => [
                        'name' => 'T-shirts',
                        'slug' => 't-shirts',
                ],

                3 => [
                        'name' => 'Sacs',
                        'slug' => 'sacs',
                ],

                4 => [
                        'name' => 'Vestes',
                        'slug' => 'vestes',
                ],

                5 => [
                        'name' => 'Bonnets',
                        'slug' => 'bonnets',
                ],

                6 => [
                        'name' => 'Chaussures',
                        'slug' => 'chaussures',
                ],
                7 => [
                        'name' => 'Jeans',
                        'slug' => 'jeans',
                ]
        ];

        foreach ($c as $k => $value){
            $categoryShop = new CategoryShop();
            $categoryShop->setName($value['name']);
            $categoryShop->setSlug($value['slug']);
            $manager->persist($categoryShop);
            $this->addReference("categoryShop-" . $k, $categoryShop);
        }

        $manager->flush();
    }
}
