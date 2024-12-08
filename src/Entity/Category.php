<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $nameUrl = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'category')]
    private Collection $events;

    /**
     * @var Collection<int, Pilot>
     */
    #[ORM\OneToMany(targetEntity: Pilot::class, mappedBy: 'categoty')]
    private Collection $pilots;

    /**
     * @var Collection<int, Constructor>
     */
    #[ORM\OneToMany(targetEntity: Constructor::class, mappedBy: 'category')]
    private Collection $constructors;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->pilots = new ArrayCollection();
        $this->constructors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNameUrl(): ?string
    {
        return $this->nameUrl;
    }

    public function setNameUrl(string $nameUrl): static
    {
        $this->nameUrl = $nameUrl;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setCategory($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCategory() === $this) {
                $event->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pilot>
     */
    public function getPilots(): Collection
    {
        return $this->pilots;
    }

    public function addPilot(Pilot $pilot): static
    {
        if (!$this->pilots->contains($pilot)) {
            $this->pilots->add($pilot);
            $pilot->setCategory($this);
        }

        return $this;
    }

    public function removePilot(Pilot $pilot): static
    {
        if ($this->pilots->removeElement($pilot)) {
            // set the owning side to null (unless already changed)
            if ($pilot->getCategory() === $this) {
                $pilot->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Constructor>
     */
    public function getConstructors(): Collection
    {
        return $this->constructors;
    }

    public function addConstructor(Constructor $constructor): static
    {
        if (!$this->constructors->contains($constructor)) {
            $this->constructors->add($constructor);
            $constructor->setCategory($this);
        }

        return $this;
    }

    public function removeConstructor(Constructor $constructor): static
    {
        if ($this->constructors->removeElement($constructor)) {
            // set the owning side to null (unless already changed)
            if ($constructor->getCategory() === $this) {
                $constructor->setCategory(null);
            }
        }

        return $this;
    }
}
