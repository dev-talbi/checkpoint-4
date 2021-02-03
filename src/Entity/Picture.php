<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Injustice::class, inversedBy="pictures")
     */
    private $injustice;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="avatar", cascade={"persist", "remove"})
     */
    private $avatar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getInjustice(): ?Injustice
    {
        return $this->injustice;
    }

    public function setInjustice(?Injustice $injustice): self
    {
        $this->injustice = $injustice;

        return $this;
    }

    public function getAvatar(): ?User
    {
        return $this->avatar;
    }

    public function setAvatar(?User $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
