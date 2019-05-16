<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
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
    private $date;

    private $date_str;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Renter", inversedBy="news")
     */
    private $renter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $preview;

    private $preview_upload;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    private $image_upload;
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



    public function __construct()
    {
        $this->renter = new ArrayCollection();
        $date = $this->getDate();
        if (isset($date)){
        $this->setDateStr($this->getDate()->format('m/d/Y'));
            }
            $this->setActive(false);
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Renter[]
     */
    public function getRenter(): Collection
    {
        return $this->renter;
    }

    public function addRenter(Renter $renter): self
    {
        if (!$this->renter->contains($renter)) {
            $this->renter[] = $renter;
        }

        return $this;
    }

    public function removeRenter(Renter $renter): self
    {
        if ($this->renter->contains($renter)) {
            $this->renter->removeElement($renter);
        }

        return $this;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(string $preview): self
    {
        $this->preview = $preview;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
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
    public function getDateStr()
    {
        return $this->date_str;
    }

    /**
     * @param mixed $date_str
     */
    public function setDateStr($date_str): void
    {
        $this->date_str = $date_str;
    }

    /**
     * @return mixed
     */
    public function getPreviewUpload()
    {
        return $this->preview_upload;
    }

    /**
     * @param mixed $preview_upload
     */
    public function setPreviewUpload($preview_upload): void
    {
        $this->preview_upload = $preview_upload;
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
