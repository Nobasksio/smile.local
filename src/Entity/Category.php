<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Renter", mappedBy="categories")
     */
    private $renters;


    public function __construct()
    {
        $this->renters = new ArrayCollection();
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return Collection|Renter[]
     */
    public function getRenters(): Collection
    {
        return $this->renters;
    }

    public function addRenter(Renter $renter): self
    {
        if (!$this->renters->contains($renter)) {
            $this->renters[] = $renter;
            $renter->addCategory($this);
        }

        return $this;
    }

    public function removeRenter(Renter $renter): self
    {
        if ($this->renters->contains($renter)) {
            $this->renters->removeElement($renter);
            $renter->removeCategory($this);
        }

        return $this;
    }



}
