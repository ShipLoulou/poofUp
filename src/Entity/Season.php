<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $years = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'currentSeason')]
    private Collection $events;

    /**
     * @var Collection<int, Pilot>
     */
    #[ORM\OneToMany(targetEntity: Pilot::class, mappedBy: 'currentSeason')]
    private Collection $pilots;

    /**
     * @var Collection<int, Constructor>
     */
    #[ORM\OneToMany(targetEntity: Constructor::class, mappedBy: 'currentSeason')]
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

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(int $years): static
    {
        $this->years = $years;

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
            $event->setCurrentSeason($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCurrentSeason() === $this) {
                $event->setCurrentSeason(null);
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
            $pilot->setCurrentSeason($this);
        }

        return $this;
    }

    public function removePilot(Pilot $pilot): static
    {
        if ($this->pilots->removeElement($pilot)) {
            // set the owning side to null (unless already changed)
            if ($pilot->getCurrentSeason() === $this) {
                $pilot->setCurrentSeason(null);
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
            $constructor->setCurrentSeason($this);
        }

        return $this;
    }

    public function removeConstructor(Constructor $constructor): static
    {
        if ($this->constructors->removeElement($constructor)) {
            // set the owning side to null (unless already changed)
            if ($constructor->getCurrentSeason() === $this) {
                $constructor->setCurrentSeason(null);
            }
        }

        return $this;
    }
}
