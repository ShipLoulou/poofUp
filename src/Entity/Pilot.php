<?php

namespace App\Entity;

use App\Repository\PilotRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PilotRepository::class)]
class Pilot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    #[Assert\Length(max: 255, maxMessage: "Le nom doit comptenir au maximum {{ limit }} caractères.")]
    private ?string $fullName = null;

    #[ORM\ManyToOne(inversedBy: 'pilots')]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'pilots')]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    private ?Season $currentSeason = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    private ?int $seasonTotalPoint = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getCategoryToString(): ?string
    {
        return $this->category->getName();
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCurrentSeasonToString(): ?string
    {
        return $this->currentSeason->getYears();
    }

    public function getCurrentSeason(): ?Season
    {
        return $this->currentSeason;
    }

    public function setCurrentSeason(?Season $currentSeason): static
    {
        $this->currentSeason = $currentSeason;

        return $this;
    }

    public function getSeasonTotalPoint(): ?int
    {
        return $this->seasonTotalPoint;
    }

    public function setSeasonTotalPoint(?int $seasonTotalPoint): static
    {
        $this->seasonTotalPoint = $seasonTotalPoint;

        return $this;
    }
}
