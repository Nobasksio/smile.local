<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_finish;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_big;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_small;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Renter", inversedBy="actions")
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateFinish(): ?\DateTimeInterface
    {
        return $this->date_finish;
    }

    public function setDateFinish(?\DateTimeInterface $date_finish): self
    {
        $this->date_finish = $date_finish;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPhotoBig(): ?string
    {
        return $this->photo_big;
    }

    public function setPhotoBig(?string $photo_big): self
    {
        $this->photo_big = $photo_big;

        return $this;
    }

    public function getPhotoSmall(): ?string
    {
        return $this->photo_small;
    }

    public function setPhotoSmall(?string $photo_small): self
    {
        $this->photo_small = $photo_small;

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
        }

        return $this;
    }

    public function removeRenter(Renter $renter): self
    {
        if ($this->renters->contains($renter)) {
            $this->renters->removeElement($renter);
        }

        return $this;
    }
}
