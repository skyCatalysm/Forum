<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    static $last_id = 0;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_threads;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_filename;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Threads", mappedBy="category")
     */
    private $threads;

    public function __construct()
    {
        $this->threads = new ArrayCollection();
        $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTotalThreads(): ?int
    {
        return $this->total_threads;
    }

    public function setTotalThreads(int $total_threads): self
    {
        $this->total_threads = $total_threads;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->image_filename;
    }

    public function setImageFilename(string $image_filename): self
    {
        $this->image_filename = $image_filename;

        return $this;
    }

    /**
     * @return Collection|Threads[]
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Threads $thread): self
    {
        if (!$this->threads->contains($thread)) {
            $this->threads[] = $thread;
            $thread->setCategory($this);
        }

        return $this;
    }

    public function removeThread(Threads $thread): self
    {
        if ($this->threads->contains($thread)) {
            $this->threads->removeElement($thread);
            // set the owning side to null (unless already changed)
            if ($thread->getCategory() === $this) {
                $thread->setCategory(null);
            }
        }

        return $this;
    }

    public function getLastId():int
    {
        return self::$last_id;
    }
}
