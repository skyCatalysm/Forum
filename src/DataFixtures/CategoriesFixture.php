<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Common\Persistence\ObjectManager;

class CategoriesFixture extends BaseFixture
{
    private static $categoriesName = [
        'Anime',
        'Animals',
        'Dota',
        'LOL',
        'Cars',
        'Basketball',
        'Food',
        'Drink',
        'Awesome',
//        'Drawing',
//        'Fortnite',
//        'Girl',
//        'Guy',
//        'Gaming',
        ];
    private static $categoriesImage = [
        'https://i.pinimg.com/564x/31/20/e6/3120e6e721e3317ddedde950be269042.jpg',
        'https://i.pinimg.com/564x/79/eb/f3/79ebf3ca815b56bec0c103a549237841.jpg',
        'https://i.pinimg.com/564x/1a/b0/05/1ab005bb2996807bd6ebab03c6670471.jpg',
        'https://i.pinimg.com/564x/32/b4/08/32b408cafc46f472b9ea3825be1621e7.jpg',
        'https://i.pinimg.com/564x/a6/f5/66/a6f566888be4f6cbe287d555747773b5.jpg',
        'https://i.pinimg.com/564x/48/22/99/482299bfe8cd8a22783fc3ce436ebe5a.jpg',
        'https://i.pinimg.com/564x/a8/ac/10/a8ac101a9b2ff1df11286b5e5ffae792.jpg',
        'https://i.pinimg.com/564x/6b/82/50/6b82503462beefd770c69e6e0063f3c1.jpg',
        'https://i.pinimg.com/564x/14/6a/5e/146a5e08bcd4b2d0fc9cbda6d80f141d.jpg',
    ];
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Categories::class,8,function(Categories $category, $count){
                $category->setName(self::$categoriesName[$count]);
                $category->setImageFilename(self::$categoriesImage[$count]);
                $category->setTotalThreads(0);
        });
        $manager->flush();
    }
}
