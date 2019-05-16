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

    private $date_start_str;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_finish;

    private $date_finish_str;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_big;

    private $photo_big_upload;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_small;

    private $photo_small_upload;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Renter", inversedBy="actions")
     */
    private $renters;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

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

    private $renter_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateStartStr()
    {
        return $this->date_start_str;
    }

    /**
     * @param mixed $date_start_str
     */
    public function setDateStartStr($date_start_str): void
    {
        $this->date_start_str = $date_start_str;
    }

    /**
     * @return mixed
     */
    public function getDateFinishStr()
    {
        return $this->date_finish_str;
    }

    /**
     * @param mixed $date_finish_str
     */
    public function setDateFinishStr($date_finish_str): void
    {
        $this->date_finish_str = $date_finish_str;
    }


    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getVk(): ?string
    {
        return $this->vk;
    }

    public function setVk(?string $vk): self
    {
        $this->vk = $vk;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenterId()
    {
        return $this->renter_id;
    }

    /**
     * @param mixed $renter_id
     */
    public function setRenterId($renter_id): void
    {
        $this->renter_id = $renter_id;
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
     * @return mixed
     */
    public function getPhotoBigUpload()
    {
        return $this->photo_big_upload;
    }

    /**
     * @param mixed $photo_big_upload
     */
    public function setPhotoBigUpload($photo_big_upload): void
    {
        $this->photo_big_upload = $photo_big_upload;
    }

    /**
     * @return mixed
     */
    public function getPhotoSmallUpload()
    {
        return $this->photo_small_upload;
    }

    /**
     * @param mixed $photo_small_upload
     */
    public function setPhotoSmallUpload($photo_small_upload): void
    {
        $this->photo_small_upload = $photo_small_upload;
    }

}
