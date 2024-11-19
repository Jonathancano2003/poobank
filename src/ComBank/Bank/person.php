<?php

namespace ComBank\Bank;

use ComBank\Support\Traits\ApiTrait;

class person
{
    private string $name;
    private string $idCard;
    private string $email;

    use ApiTrait;

    public function __construct(string $name, string $idCard, string $email)
    {
        if (!$this->validateEmail($email)) {
            echo "El correo electrónico no es válido. La persona no ha sido creada." . PHP_EOL;
            return;
        }

        $this->name = $name;
        $this->idCard = $idCard;
        $this->email = $email;

        echo "Correo electrónico válido. Persona creada con éxito." . PHP_EOL;
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
