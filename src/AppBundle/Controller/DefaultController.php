<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use abeautifulsite\SimpleImage;

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

            $this->get('image_resizer')->generateSmallerImage($newImage);

        }

        $params = array(
            'imageForm' => $imageForm->createView()
        );
        return $this->render('upload/index.html.twig', $params);
    }


    /**
     * @Route("/trad", name="trad")
     */
    public function tradAction()
    {

        $params = array();

        return $this->render('trad/index.html.twig', $params);
    }
}
