<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Salle controller.
 *
 */
class SalleController extends Controller
{
    /**
     * Lists all salle entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $salles = $em->getRepository('AppBundle:Salle')->findAll();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('salle/index.html.twig', array(
            'salles' => $salles,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new salle entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle();
        $form = $this->createForm('AppBundle\Form\SalleType', $salle);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($salle);
            $em->flush();

            return $this->redirectToRoute('salle_show', array('id' => $salle->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('salle/new.html.twig', array(
            'salle' => $salle,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a salle entity.
     *
     */
    public function showAction(Salle $salle)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($salle);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('salle/show.html.twig', array(
            'salle' => $salle,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing salle entity.
     *
     */
    public function editAction(Request $request, Salle $salle)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($salle);
        $editForm = $this->createForm('AppBundle\Form\SalleType', $salle);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('salle_edit', array('id' => $salle->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('salle/edit.html.twig', array(
            'salle' => $salle,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a salle entity.
     *
     */
    public function deleteAction(Request $request, Salle $salle)
    {
        $form = $this->createDeleteForm($salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salle);
            $em->flush();
        }

        return $this->redirectToRoute('salle_index');
    }

    /**
     * Creates a form to delete a salle entity.
     *
     * @param Salle $salle The salle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Salle $salle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salle_delete', array('id' => $salle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
