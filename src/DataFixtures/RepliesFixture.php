<?php

namespace App\DataFixtures;

use App\Entity\Replies;
use App\Entity\Threads;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RepliesFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Replies::class,100,function(Replies $reply, $count){
            $reply->setAuthor($this->getRandomReference(User::class));
            $reply->setThread($this->getRandomReference(Threads::class));
            $reply->setContent($this->faker->text);
            $reply->setCreatedAt(new \DateTime());
            $reply->setUpdatedAt(new \DateTime());
        });
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [UsersFixture::class,ThreadsFixture::class];
    }
}
