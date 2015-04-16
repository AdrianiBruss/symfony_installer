<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Visit;

class TestListener {

    private $doctrine;

    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }

    public function yo($event){

//        dump('yo maaaan');
//
        //$array = $event->getRequest()->headers->all()['referer'][0];
        //$date = $event->getRequest()->server->all()['REQUEST_TIME'];
//        dump($event->getRequest()->getClientIp());

        if (!($event->isMasterRequest()) ){
            return ;
        }

        $request = $event->getRequest();

        $newVisit = new Visit();
        $newVisit->setUrl($request->getUri());
        $newVisit->setDate(new \DateTime());
        $newVisit->setIp($request->getClientIp());

        if ( !($event->isMasterRequest()) ||
            strstr($newVisit->getUrl(), ".css") !== false ||
            strstr($newVisit->getUrl(), "_wdt") !== false

        ){
            return;
        }

        $em = $this->doctrine->getManager();

        $em->persist($newVisit);
        $em->flush();


//        dump($event->getKernel());
//        dump(get_class_methods($event));

        //url $event->getRequest()->headers

    }
}