<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contest;
use AppBundle\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContestController
 * @package AppBundle\Controller
 * @Route("/contest")
 */
class ContestController extends Controller
{
    /**
     * @Route("/choose", name="app_frontoffice_contest_choose")
     */
    public function chooseAction()
    {
        // 1) get all photos, managed by a form

        $user = $this->getUser();
        $repository = $this->get('picture.repository');
        $photos = $repository->getPicturesByUser($user);
        dump($photos);
        return new Response('lel');
        // 2) choose a photo to submit
        // 3) save in db
    }

    /**
     * @Route("/participate/{photoId}", name="app_frontoffice_contest_participate")
     */
    public function participateAction($photoId)
    {
        // 1) get all photos, managed by a form

        $user = $this->getUser();
        $repository = $this->get('picture.repository');

        $facebookPhoto = $repository->getPictureById($user, $photoId);
        /** @var Contest $contest */
        $contest = $this->getDoctrine()->getRepository('AppBundle:Contest')->getCurrentContest();
        $photo = new Picture();
        $photo
            ->addContest($contest)
            ->setFacebookId($photoId)
            ->setRepresentation($facebookPhoto->getField('picture'))
        ;
        $contest->addPicture($photo);

        $em = $this->getDoctrine()->getManager();
        $em->persist($photo);
        $em->flush();
        return new Response('lel');
        // 2) choose a photo to submit
        // 3) save in db
    }

}
