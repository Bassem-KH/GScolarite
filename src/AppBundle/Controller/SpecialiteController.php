<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Specialite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specialite controller.
 *
 */
class SpecialiteController extends Controller
{
    /**
     * Lists all specialite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $specialites = $em->getRepository('AppBundle:Specialite')->findAll();

        return $this->render('specialite/index.html.twig', array(
            'specialites' => $specialites,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new specialite entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $specialite = new Specialite();
        $form = $this->createForm('AppBundle\Form\SpecialiteType', $specialite);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($specialite);
            $em->flush();

            return $this->redirectToRoute('specialite_show', array('id' => $specialite->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('specialite/new.html.twig', array(
            'specialite' => $specialite,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialite entity.
     *
     */
    public function showAction(Specialite $specialite)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($specialite);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('specialite/show.html.twig', array(
            'specialite' => $specialite,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialite entity.
     *
     */
    public function editAction(Request $request, Specialite $specialite)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($specialite);
        $editForm = $this->createForm('AppBundle\Form\SpecialiteType', $specialite);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialite_edit', array('id' => $specialite->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('specialite/edit.html.twig', array(
            'specialite' => $specialite,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specialite entity.
     *
     */
    public function deleteAction(Request $request, Specialite $specialite)
    {
        $form = $this->createDeleteForm($specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialite);
            $em->flush();
        }

        return $this->redirectToRoute('specialite_index');
    }

    /**
     * Creates a form to delete a specialite entity.
     *
     * @param Specialite $specialite The specialite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specialite $specialite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialite_delete', array('id' => $specialite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
