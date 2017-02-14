<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contest;
use AppBundle\Entity\FacebookUser;
use AppBundle\Entity\Picture;
use AppBundle\Entity\User;
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
        $user = $this->getUser();
        $repository = $this->get('picture.repository');
        $photos = $repository->getPicturesByUser($user);
        return new Response('lel');
    }

    /**
     * @Route("/participate/{photoId}", name="app_frontoffice_contest_participate")
     */
    public function participateAction($photoId)
    {
        /** @var FacebookUser $facebookUser */
        $facebookUser = $this->getUser();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->getByFacebookUser($facebookUser);

        $repository = $this->get('picture.repository');

        $facebookPhoto = $repository->getPictureById($facebookUser, $photoId);
        /** @var Contest $contest */
        $contest = $this->getDoctrine()->getRepository('AppBundle:Contest')->getCurrentContest();
        $photo = new Picture();
        $photo
            ->addContest($contest)
            ->setFacebookId($photoId)
            ->setRepresentation($facebookPhoto->getField('picture'))
            ->setUser($user)
        ;
        $contest->addPicture($photo);
        $user->addPhoto($photo);

        $em = $this->getDoctrine()->getManager();
        $em->persist($photo);
        $em->flush();
        return new Response('lel');
    }

    /**
     * @Route("/remove/{picture}", name="app_frontoffice_contest_remove")
     *
     * @param Picture $picture
     * @return Response
     */
    public function removePhoto(Picture $picture)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->getByFacebookUser($this->getUser());

        if ($picture->getUser() !== $user) {
            return new Response('nope');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($picture);
        $em->flush();
        return new Response('removed');
    }
}
