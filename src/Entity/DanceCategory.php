<?php

namespace App\Entity;

use App\Repository\DanceCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DanceCategoryRepository::class)]
class DanceCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, DanceSchool>
     */
    #[ORM\OneToMany(targetEntity: DanceSchool::class, mappedBy: 'danceCategory')]
    private Collection $danceSchools;

    public function __construct()
    {
        $this->danceSchools = new ArrayCollection();
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

    /**
     * @return Collection<int, DanceSchool>
     */
    public function getDanceSchools(): Collection
    {
        return $this->danceSchools;
    }

    public function addDanceSchool(DanceSchool $danceSchool): static
    {
        if (!$this->danceSchools->contains($danceSchool)) {
            $this->danceSchools->add($danceSchool);
            $danceSchool->setDanceCategory($this);
        }

        return $this;
    }

    public function removeDanceSchool(DanceSchool $danceSchool): static
    {
        if ($this->danceSchools->removeElement($danceSchool)) {
            // set the owning side to null (unless already changed)
            if ($danceSchool->getDanceCategory() === $this) {
                $danceSchool->setDanceCategory(null);
            }
        }

        return $this;
    }
}
