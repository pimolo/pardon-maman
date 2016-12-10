<?php

namespace AppBundle\Controller\BackOffice;

use AppBundle\Entity\Contest;
use AppBundle\Form\Type\ContestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContestController
 * @package AppBundle\Controller\BackOffice
 * @Route("/contest")
 */
class ContestController extends Controller
{
    /**
     * @Route("/", name="app_backoffice_contest_index")
     * @return Response
     */
    public function indexContestAction()
    {
        $contests = $this->getDoctrine()->getRepository('AppBundle:Contest')->findAll();

        return $this->render('backoffice/contests/index.html.twig', [
            'contests' => $contests,
        ]);
    }

    /**
     * @Route("/new", name="app_backoffice_contest_new")
     * @param Request $request
     * @return Response
     */
    public function newContestAction(Request $request)
    {
        $contest = new Contest();
        $now = new \DateTimeImmutable();
        $contest->setDateStart($now);
        $contest->setDateEnd($now->modify('+1 month'));

        $form = $this->createForm(ContestType::class, $contest);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contest);
            $em->flush();

            return $this->redirectToRoute('app_backoffice_contest_index');
        }

        return $this->render('backoffice/contests/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{contest}", name="app_backoffice_contest_edit")
     * @param Request $request
     * @param Contest $contest
     * @return Response
     */
    public function editContestAction(Request $request, Contest $contest)
    {
        $form = $this->createForm(ContestType::class, $contest);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contest);
            $em->flush();

            return $this->redirectToRoute('app_backoffice_contest_index');
        }

        return $this->render('backoffice/contests/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{contest}", name="app_backoffice_contest_delete")
     * @param Contest $contest
     * @return Response
     */
    public function deleteContestAction(Contest $contest)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contest);
        $em->flush();

        $contests = $this->getDoctrine()->getRepository('AppBundle:Contest')->findAll();

        return $this->render('backoffice/contests/index.html.twig', [
            'contests' => $contests,
        ]);
    }
}
