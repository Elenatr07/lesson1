<?php
namespace Geekbrains\LevelTwo\Person;
class Name {
    private string $firstName;
    private string $lastName;
    public function __construct( string $firstName, string $lastName ) 
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
    public function __toString() {
        return $this->firstName . ' ' . $this->lastName.PHP_EOL;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function setFirstName (string $firstName): void 
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function setLastName(string $lastName): void 
    {
        $this->lastName = $lastName;
    }
}