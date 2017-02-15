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
        $em = $this->getDoctrine()->getManager();
        $photos = $repository->getPicturesByUser($user);
        $cgu = $em->getRepository('AppBundle:Configuration')->find(1)->getCgu();

        return $this->render(':upload:index.html.twig', ['cgu' => $cgu, 'photos' => $photos->asArray()]);
    }

    /**
     * @Route("/choose-to-vote", name="app_frontoffice_contest_choose_to_vote")
     */
    public function chooseToVoteAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Contest');
        $contest = $repository->getCurrentContest();
        $photos = $contest->getPictures();
        $cgu = $em->getRepository('AppBundle:Configuration')->find(1)->getCgu();

        return $this->render(':upload:choose_to_vote.html.twig', ['cgu' => $cgu, 'photos' => $photos]);
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
    public function removePhotoAction(Picture $picture)
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

    /**
     * @Route("/vote/{picture}", name="app_frontoffice_contest_vote")
     *
     * @param Picture $picture
     * @return Response
     */
    public function voteAction(Picture $picture)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->getByFacebookUser($this->getUser());

        if ($picture->getVoters()->contains($user)) {
            return new Response('déjà voté');
        }

        $user->addVote($picture);
        $picture->addVoter($user);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response('ok');
    }
}
