<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UsersFixture extends BaseFixture
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class,10,function(User $user, $count){
           $user->setEmail("test".$count."@test.com");
           $user->setPassword("test");
        });

        $manager->flush();
    }
}
