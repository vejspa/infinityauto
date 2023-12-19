<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CarMakeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarMakeRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/car_makes',
        ),
        new Get(
            uriTemplate: '/car_makes/{id}',
        ),
        new Post(
            uriTemplate: '/car_makes',
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            uriTemplate: '/car_makes/{id}',
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            uriTemplate: '/car_makes/{id}',
            security: "is_granted('ROLE_ADMIN')"
        ),
    ]
)]

class CarMake
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: "make", targetEntity: CarModel::class)]
    private Collection $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $make_id): static
    {
        $this->id = $make_id;

        return $this;
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

    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(CarModel $model): Collection
    {
        if (!$this->models->contains($model)) {
            $this->models->add($model);
            $model->setMake($this);
        }

        return $this->models;
    }

    public function removeModel(CarModel $model): Collection
    {
        if ($this->models->removeElement($model)) {
            if ($model->getMake() === $this) {
                $model->setMake(null);
            }
        }

        return $this->models;
    }
}
