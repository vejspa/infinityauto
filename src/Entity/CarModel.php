<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CarModelRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CarModelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarModelRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/car_models',
            status: 200,
        ),
        new Get(
            uriTemplate: '/car_models/{id}',
            status: 200,
        ),
        new Post(
            uriTemplate: '/car_models/{id}',
            status: 201,
        ),
        new Put(
            uriTemplate: '/car_models/{id}',
            status: 201,
        ),
        new Delete(
            uriTemplate: '/car_models/{id}',
            status: 204,
        ),
    ]
)]
class CarModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: "models", targetEntity: CarType::class)]
    private Collection $models;

    #[ORM\ManyToOne(targetEntity: CarMake::class, inversedBy: "models")]
    #[ORM\JoinColumn(name: "make_id", referencedColumnName: "id")]
    private ?CarMake $make = null;

    #[ORM\OneToMany(mappedBy: 'models', targetEntity: CarType::class)]
    private Collection $types;
    #[ORM\Column]
    private ?int $model_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $make_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelId(): ?int
    {
        return $this->model_id;
    }

    public function setModelId(int $model_id): static
    {
        $this->model_id = $model_id;

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

    public function getMakeId(): ?int
    {
        return $this->make_id;
    }

    public function setMakeId(int $make_id): static
    {
        $this->make_id = $make_id;

        return $this;
    }

    public function getMake(): ?CarMake
    {
        return $this->make;
    }

    public function setMake(?CarMake $carMake): static
    {
        $this->make = $carMake;

        return $this;
    }

    /**
     * @return Collection<int, CarType>
     */
    public function getVariant(): Collection
    {
        return $this->types;
    }

    public function addVariant(CarType $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->setModel($this);
        }

        return $this;
    }

    public function removeVariant(CarType $type): static
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getModel() === $this) {
                $type->setModel(null);
            }
        }

        return $this;
    }
}
