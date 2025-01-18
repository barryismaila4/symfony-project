<?php

namespace App\Entity;

use App\Repository\DanceSchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DanceSchoolRepository::class)]
class DanceSchool
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    #[ORM\Column(length: 255)]
    private ?string $openday = null;

    #[ORM\Column(length: 255)]
    private ?string $closeday = null;

    #[ORM\Column(length: 255)]
    private ?string $opentime = null;

    #[ORM\Column(length: 255)]
    private ?string $closetime = null;

    #[ORM\ManyToOne(inversedBy: 'danceSchools')]
    private ?DanceCategory $danceCategory = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'danceSchool')]
    private Collection $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getOpenday(): ?string
    {
        return $this->openday;
    }

    public function setOpenday(string $openday): static
    {
        $this->openday = $openday;

        return $this;
    }

    public function getCloseday(): ?string
    {
        return $this->closeday;
    }

    public function setCloseday(string $closeday): static
    {
        $this->closeday = $closeday;

        return $this;
    }

    public function getOpentime(): ?string
    {
        return $this->opentime;
    }

    public function setOpentime(string $opentime): static
    {
        $this->opentime = $opentime;

        return $this;
    }

    public function getClosetime(): ?string
    {
        return $this->closetime;
    }

    public function setClosetime(string $closetime): static
    {
        $this->closetime = $closetime;

        return $this;
    }

    public function getDanceCategory(): ?DanceCategory
    {
        return $this->danceCategory;
    }

    public function setDanceCategory(?DanceCategory $danceCategory): static
    {
        $this->danceCategory = $danceCategory;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setDanceSchool($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getDanceSchool() === $this) {
                $course->setDanceSchool(null);
            }
        }

        return $this;
    }
}
