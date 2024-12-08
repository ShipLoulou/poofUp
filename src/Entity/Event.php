<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    #[Assert\Length(max: 255, maxMessage: "Le nom doit comptenir au maximum {{ limit }} caractères.")]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'images_event', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    private ?\DateTimeInterface $raceDate = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Assert\NotBlank(message: "Champs obligatoire")]
    private ?Season $currentSeason = null;

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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getStartDateToString(): ?string
    {
        $startDate = $this->startDate;
        if ($startDate) {
            return $startDate->format('d/m');
        }
        return null;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDateToString(): ?string
    {
        $endDate = $this->endDate;
        if ($endDate) {
            return $endDate->format('d/m');
        }
        return null;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRaceDateToString(): ?string
    {
        $raceDate = $this->raceDate;
        return $raceDate->format('d/m');
    }

    public function getRaceDate(): ?\DateTimeInterface
    {
        return $this->raceDate;
    }

    public function setRaceDate(?\DateTimeInterface $raceDate): static
    {
        $this->raceDate = $raceDate;

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
}
