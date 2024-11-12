<?php

namespace ComBank\Bank;

class person
{
    private string $name;
    private string $idCard;
    private string $email;

    public function __construct(string $name, string $idCard, string $email)
    {
        $this->name = $name;
        $this->idCard = $idCard;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdCard(): string
    {
        return $this->idCard;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
