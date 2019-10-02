<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Seance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Seance controller.
 *
 */
class SeanceController extends Controller
{
    /**
     * Lists all seance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $seances = $em->getRepository('AppBundle:Seance')->findAll();


        return $this->render('seance/index.html.twig', array(
            'seances' => $seances,
        ));
    }

    /**
     * Creates a new seance entity.
     *
     */
    public function newAction(Request $request)
    {
        $seance = new Seance();
        $form = $this->createForm('AppBundle\Form\SeanceType', $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seance);
            $em->flush();

            return $this->redirectToRoute('seance_show', array('id' => $seance->getId()));
        }

        return $this->render('seance/new.html.twig', array(
            'seance' => $seance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a seance entity.
     *
     */
    public function showAction(Seance $seance)
    {
        $deleteForm = $this->createDeleteForm($seance);

        return $this->render('seance/show.html.twig', array(
            'seance' => $seance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing seance entity.
     *
     */
    public function editAction(Request $request, Seance $seance)
    {
        $deleteForm = $this->createDeleteForm($seance);
        $editForm = $this->createForm('AppBundle\Form\SeanceType', $seance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seance_edit', array('id' => $seance->getId()));
        }

        return $this->render('seance/edit.html.twig', array(
            'seance' => $seance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a seance entity.
     *
     */
    public function deleteAction(Request $request, Seance $seance)
    {
        $form = $this->createDeleteForm($seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($seance);
            $em->flush();
        }

        return $this->redirectToRoute('seance_index');
    }

    /**
     * Creates a form to delete a seance entity.
     *
     * @param Seance $seance The seance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Seance $seance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seance_delete', array('id' => $seance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
