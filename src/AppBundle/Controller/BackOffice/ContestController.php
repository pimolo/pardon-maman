<?php

namespace AppBundle\Controller\BackOffice;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Contest;
use AppBundle\Form\Type\ContestType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("", name="app_backoffice_contest_index")
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

    /**
     * @Route("/cgu", name="app_backoffice_cgu")
     * @param Request $request
     * @return Response
     */
    public function editCguAction(Request $request)
    {
        $form = $this
            ->createFormBuilder()
            ->add('cgu', CKEditorType::class)
            ->add('save', SubmitType::class, array('label' => 'Valider'))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $cgu = $form->get('cgu')->getData();

            $em = $this->getDoctrine()->getManager();

            $config = $em->getRepository('AppBundle:Configuration')->find(1);
            if (empty($config)) {
                $config = new Configuration();
            }

            $config->setCgu($cgu);

            $em->persist($config);
            $em->flush();

            return $this->redirectToRoute('cgu');
        }

        return $this->render('backoffice/cgu.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/rules", name="app_backoffice_rules")
     * @param Request $request
     * @return Response
     */
    public function editRulesAction(Request $request)
    {
        $form = $this
            ->createFormBuilder()
            ->add('rules', CKEditorType::class)
            ->add('save', SubmitType::class, array('label' => 'Valider'))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $rules = $form->get('rules')->getData();

            $em = $this->getDoctrine()->getManager();

            $config = $em->getRepository('AppBundle:Configuration')->find(1);
            if (empty($config)) {
                $config = new Configuration();
            }

            $config->setRules($rules);

            $em->persist($config);
            $em->flush();

            return $this->redirectToRoute('rules');
        }

        return $this->render('backoffice/rules.html.twig', ['form' => $form->createView()]);
    }
}
