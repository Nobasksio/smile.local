<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberRepository")
 */
class Subscriber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $тфname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_subscribe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_activate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getтфname(): ?string
    {
        return $this->тфname;
    }

    public function setтфname(?string $тфname): self
    {
        $this->тфname = $тфname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateSubscribe(): ?\DateTimeInterface
    {
        return $this->date_subscribe;
    }

    public function setDateSubscribe(\DateTimeInterface $date_subscribe): self
    {
        $this->date_subscribe = $date_subscribe;

        return $this;
    }

    public function getActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function getDateActivate(): ?\DateTimeInterface
    {
        return $this->date_activate;
    }

    public function setDateActivate(?\DateTimeInterface $date_activate): self
    {
        $this->date_activate = $date_activate;

        return $this;
    }
}
