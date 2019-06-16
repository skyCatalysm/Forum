<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Common\Persistence\ObjectManager;

class CategoriesFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Categories::class,10,function(Categories $category, $count){
            $category->setName($this->faker->word);
            $category->setImageFilename($this->faker->name);
            $category->setTotalThreads(0);
        });
        $manager->flush();
    }
}
