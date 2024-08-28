<?php

namespace Kevinrevill\Plentific\Models;

class User implements \JsonSerializable
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $avatar;

    public function __construct(int $id, string $firstName, string $lastName, string $email, string $avatar)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->avatar = $avatar;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'avatar' => $this->avatar,
        ];
    }

    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}