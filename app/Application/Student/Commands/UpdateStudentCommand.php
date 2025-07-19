<?php

namespace App\Application\Student\Commands;

class UpdateStudentCommand
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->email = $data['email'];
    }

    public function id(): int
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }
}