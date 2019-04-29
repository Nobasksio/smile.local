<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RenterRepository")
 */
class Renter
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
    private $floor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo_big;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo_small;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\News", mappedBy="renter")
     */
    private $news;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Action", mappedBy="renters")
     */
    private $actions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocialMedia", mappedBy="renter")
     */
    private $socialMedia;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->actions = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
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

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

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

    public function getLogoBig(): ?string
    {
        return $this->logo_big;
    }

    public function setLogoBig(?string $logo_big): self
    {
        $this->logo_big = $logo_big;

        return $this;
    }

    public function getLogoSmall(): ?string
    {
        return $this->logo_small;
    }

    public function setLogoSmall(string $logo_small): self
    {
        $this->logo_small = $logo_small;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
     * @return Collection|News[]
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->addRenter($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->contains($news)) {
            $this->news->removeElement($news);
            $news->removeRenter($this);
        }

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->addRenter($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            $action->removeRenter($this);
        }

        return $this;
    }

    /**
     * @return Collection|SocialMedia[]
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    public function addSocialMedium(SocialMedia $socialMedium): self
    {
        if (!$this->socialMedia->contains($socialMedium)) {
            $this->socialMedia[] = $socialMedium;
            $socialMedium->setRenter($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->contains($socialMedium)) {
            $this->socialMedia->removeElement($socialMedium);
            // set the owning side to null (unless already changed)
            if ($socialMedium->getRenter() === $this) {
                $socialMedium->setRenter(null);
            }
        }

        return $this;
    }
}
