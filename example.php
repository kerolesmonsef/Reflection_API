<?php

class Human
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(int $val): string
    {
        return $this->name;
    }
}

$human = new Human("keroles");
$reflection = new ReflectionMethod($human,"getName");


print "<pre>";
print($_SERVER['REQUEST_URI']);
print "</pre>";
