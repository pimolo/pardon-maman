<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/gallery", name="gallery")
 */
class GalleryController extends Controller
{
  /**
   * @Route("/", name="gallery_index")
   */
  public function indexAction(Request $request)
  {
    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:Contest');
    $contest = $repository->getCurrentContest();
    $photos = $contest->getPictures();
    $cgu = $em->getRepository('AppBundle:Configuration')->find(1)->getCgu();
    // replace this example code with whatever you need
    return $this->render('gallery/index.html.twig', ['cgu' => $cgu, 'photos' => $photos]);
  }

  /**
   * @Route("/{slug}", name="gallery_show")
   */
  public function showAction(Request $request, $slug)
  {


    return $this->render('gallery/show.html.twig', [
      'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    ]);
  }
}
