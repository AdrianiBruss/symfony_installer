<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function uploadAction(Request $request)
    {

        $newImage = new Image();

        $imageForm = $this->createForm(new ImageType(), $newImage);
        $imageForm->handleRequest($request);

        if ($imageForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($newImage);

            $em->flush();

        }

        $params = array(
            'imageForm' => $imageForm->createView()
        );
        return $this->render('upload/index.html.twig', $params);
    }
}
