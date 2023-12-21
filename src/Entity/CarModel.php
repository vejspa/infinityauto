<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Link;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
        new Get(
            uriTemplate: '/car_makes/{make_id}/car_models/{id}',
            uriVariables: [
                'make_id' => new Link(
                    toProperty: 'make',
                    fromClass: CarMake::class
                ),
                'id' => new Link(
                    fromClass: CarModel::class
                )
            ],
            status: 200,
        ),
        new Post(
            uriTemplate: '/car_models',
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

    #[ORM\ManyToOne(targetEntity: CarMake::class, inversedBy: "models")]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id")]
    private ?CarMake $make = null;

    #[ORM\OneToMany(mappedBy: "model", targetEntity: CarType::class)]
    private Collection $types;
  
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $make_id = null;

    public function __construct()
    {
        $this->types = new ArrayCollection();
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
    public function getType(): Collection
    {
        return $this->types;
    }

    public function addType(CarType $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->setModel($this);
        }

        return $this;
    }

    public function removeType(CarType $type): static
    {
        if ($this->types->removeElement($type)) {
            if ($type->getModel() === $this) {
                $type->setModel(null);
            }
        }

        return $this;
    }
}
