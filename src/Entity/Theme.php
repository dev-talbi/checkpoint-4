<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\ManyToMany(targetEntity=Injustice::class, mappedBy="theme")
     */
    private $injustices;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    public function __construct()
    {
        $this->injustices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Collection|Injustice[]
     */
    public function getInjustices(): Collection
    {
        return $this->injustices;
    }

    public function addInjustice(Injustice $injustice): self
    {
        if (!$this->injustices->contains($injustice)) {
            $this->injustices[] = $injustice;
            $injustice->addTheme($this);
        }

        return $this;
    }

    public function removeInjustice(Injustice $injustice): self
    {
        if ($this->injustices->removeElement($injustice)) {
            $injustice->removeTheme($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->subject;
        return $this->icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
