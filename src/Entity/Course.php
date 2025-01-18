<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: "text")]  // Utilisation du type "text" pour permettre une grande longueur
    private ?string $contenu = null;

    #[ORM\Column(length: 255)]
    private ?string $instructor = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?DanceSchool $danceSchool = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getInstructor(): ?string
    {
        return $this->instructor;
    }

    public function setInstructor(string $instructor): static
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getDanceSchool(): ?DanceSchool
    {
        return $this->danceSchool;
    }

    public function setDanceSchool(?DanceSchool $danceSchool): static
    {
        $this->danceSchool = $danceSchool;

        return $this;
    }
}
