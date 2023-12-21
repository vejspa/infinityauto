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
use App\Repository\CarTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarTypeRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/car_types',
            status: 200,
        ),
        new Get(
            uriTemplate: '/car_types/{id}',
            status: 200,
        ),
        new Get(
            uriTemplate: '/car_makes/{make_id}/car_models/{model_id}/car_types/{id}',
            uriVariables: [
                'make_id' => new Link(
                    toProperty: 'make',
                    fromClass: CarType::class
                ),
                'model_id' => new Link(
                    toProperty: 'model',
                    fromClass: CarType::class
                ),
                'id' => new Link(
                    fromClass: CarType::class
                )
            ],
            status: 200,
        ),
        new Post(
            uriTemplate: '/car_types/{id}',
            status: 201,
        ),
        new Put(
            uriTemplate: '/car_types/{id}',
            status: 201,
        ),
        new Delete(
            uriTemplate: '/car_types/{id}',
            status: 204,
        ),
    ]
)]
class CarType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: CarModel::class, inversedBy: "types")]
    #[ORM\JoinColumn(name: "model_id", referencedColumnName: "id")]
    private ?CarModel $model = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTypeId(int $type_id): static
    {
        $this->type_id = $type_id;

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

    public function getModel(): ?CarModel
    {
        return $this->model;
    }

    public function setModel(?CarModel $model): static
    {
        $this->model = $model;

        return $this;
    }
}
