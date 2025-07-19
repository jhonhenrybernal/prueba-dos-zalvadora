<?php
namespace App\Application\Student\Commands;

class CreateStudentCommand
{
    private string $firstName;
    private string $lastName;
    private string $email;

    public function __construct(array $data)
    {
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->email = $data['email'];
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