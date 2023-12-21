<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/cars',
            status: 200,
        ),
        new Get(
            uriTemplate: '/cars/{id}',
            status: 200,

        ),
        new Post(
            uriTemplate: '/cars/{id}',
            status: 201,
            denormalizationContext: ['groups' => ['write']],

        ),
        new Put(
            uriTemplate: '/cars/{id}',
            status: 201,
            denormalizationContext: ['groups' => ['write']],

        ),
        new Delete(
            uriTemplate: '/cars/{id}',
            status: 204,
            denormalizationContext: ['groups' => ['write']],

        ),
    ]
)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true)]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('write')]
    private ?int $car_id = null;

    #[ORM\Column]
    #[Groups('write')]
    private ?int $model_id = null;

    #[ORM\Column]
    #[Groups('write')]
    private ?int $make_id = null;

    #[ORM\Column]
    #[Groups('write')]
    private ?int $type_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarId(): ?int
    {
        return $this->car_id;
    }

    public function setCarId(int $car_id): static
    {
        $this->car_id = $car_id;

        return $this;
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

    public function getMakeId(): ?int
    {
        return $this->make_id;
    }

    public function setMakeId(int $make_id): static
    {
        $this->make_id = $make_id;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): static
    {
        $this->type_id = $type_id;

        return $this;
    }
}
