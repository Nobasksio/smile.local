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
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    private $logo_upload;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo_grey;

    private $logo_grey_upload;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    private $image_upload;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vk;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MapPlace", mappedBy="renter", cascade={"persist", "remove"})
     */
    private $mapPlace;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="renters")
     */
    private $categories;



    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->actions = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogoGrey(): ?string
    {
        return $this->logo_grey;
    }

    public function setLogoGrey(string $logo_grey): self
    {
        $this->logo_grey = $logo_grey;

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
     * @return mixed
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param mixed $instagram
     */
    public function setInstagram($instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @return mixed
     */
    public function getVk()
    {
        return $this->vk;
    }

    /**
     * @param mixed $vk
     */
    public function setVk($vk): void
    {
        $this->vk = $vk;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }


    public function getActive(): ?bool
    {
        return $this->active;
    }


    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getMapPlace(): ?MapPlace
    {
        return $this->mapPlace;
    }

    public function setMapPlace(?MapPlace $mapPlace): self
    {
        $this->mapPlace = $mapPlace;

        // set (or unset) the owning side of the relation if necessary
        $newRenter = $mapPlace === null ? null : $this;
        if ($newRenter !== $mapPlace->getRenter()) {
            $mapPlace->setRenter($newRenter);
        }

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

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }


    /**
     * @return mixed
     */
    public function getLogoStr()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo_str
     */
    public function setLogoStr($logo_str): void
    {
        $this->logo_str = $logo_str;
    }

    /**
     * @return mixed
     */
    public function getLogoGreyStr()
    {
        return $this->logo_grey;
    }

    /**
     * @param mixed $logo_grey_str
     */
    public function setLogoGreyStr($logo_grey_str): void
    {
        $this->logo_grey_str = $logo_grey_str;
    }

    /**
     * @return mixed
     */
    public function getImageStr()
    {
        return $this->image;
    }

    /**
     * @param mixed $image_str
     */
    public function setImageStr($image_str): void
    {
        $this->image_str = $image_str;
    }

    /**
     * @return mixed
     */
    public function getLogoUpload()
    {
        return $this->logo_upload;
    }

    /**
     * @param mixed $logo_upload
     */
    public function setLogoUpload($logo_upload): void
    {
        $this->logo_upload = $logo_upload;
    }

    /**
     * @return mixed
     */
    public function getLogoGreyUpload()
    {
        return $this->logo_grey_upload;
    }

    /**
     * @param mixed $logo_grey_upload
     */
    public function setLogoGreyUpload($logo_grey_upload): void
    {
        $this->logo_grey_upload = $logo_grey_upload;
    }

    /**
     * @return mixed
     */
    public function getImageUpload()
    {
        return $this->image_upload;
    }

    /**
     * @param mixed $image_upload
     */
    public function setImageUpload($image_upload): void
    {
        $this->image_upload = $image_upload;
    }

}
