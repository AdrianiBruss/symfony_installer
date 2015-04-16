<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;


class CustomEvent extends Event{

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}