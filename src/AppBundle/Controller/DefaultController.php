<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction(Request $request)
    {
        $redirect = $request->get('redirect') ?: $this->get('router')->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->redirect($this->get('facebook.helper')->loginPage($redirect));
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function uploadAction(Request $request)
    {
        return $this->render('upload/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
