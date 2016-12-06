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
    // replace this example code with whatever you need
    return $this->render('gallery/index.html.twig', [

    ]);
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
