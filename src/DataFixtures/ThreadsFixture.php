<?php

namespace App\DataFixtures;

use App\Entity\Threads;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ThreadsFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Threads::class,10,function(Threads $thread, $count){
            $thread->setSubject($this->faker->name);
            $thread->setContent($this->faker->text);
            $thread->setCreatedAt(new \DateTime());
            $thread->setUpdatedAt(new \DateTime());

            $thread->setAuthor($this->getRandomReference(User::class));
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
        return [UsersFixture::class];
    }
}
