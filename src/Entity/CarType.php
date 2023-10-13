<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
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

    #[ORM\Column]
    private ?int $type_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
