<?php

namespace App\Domain\Entities;

class Patient
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public ?string $document,
        public ?string $address,
        public ?string $birth_date,
        public ?string $gender
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? '',
            email: $data['email'] ?? '',
            phone: $data['phone'] ?? null,
            document: $data['document'] ?? null,
            address: $data['address'] ?? null,
            birth_date: $data['birth_date'] ?? null,
            gender: $data['gender'] ?? null,
        );
    }
}