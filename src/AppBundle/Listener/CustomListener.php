<?php

namespace AppBundle\Listener;

use AppBundle\Event\CustomEvent;

class CustomListener {

    public function customHandler(CustomEvent $event){

//        dump('customListener called', $event);

//
//        dump($event->getReponse());
//        dump(get_class_methods($event));

    }
}