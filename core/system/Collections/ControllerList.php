<?php

declare(strict_types=1);

namespace Spreng\system\Collections;

use Spreng\http\RequestController;

class ControllerList
{
    private $controllers = [];

    public function __construct($controllers = [])
    {
        $this->controllers = $controllers;
    }

    public function addController(RequestController $controller)
    {
        $this->controllers[] = $controller;
    }

    public function getAll()
    {
        return $this->controllers;
    }
}
