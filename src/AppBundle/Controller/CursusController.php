<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cursus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cursus controller.
 *
 */
class CursusController extends Controller
{
    /**
     * Lists all cursus entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $cursuses = $em->getRepository('AppBundle:Cursus')->findAll();

        return $this->render('cursus/index.html.twig', array(
            'cursuses' => $cursuses,'classes'=>$listeClasses,'cursu'=>$listeCursus,
        ));
    }

    /**
     * Creates a new cursus entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cursus = new Cursus();
        $form = $this->createForm('AppBundle\Form\CursusType', $cursus);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($cursus);
            $em->flush();

            return $this->redirectToRoute('cursus_show', array('id' => $cursus->getId(),'classes'=>$listeClasses,'cursu'=>$listeCursus,));
        }

        return $this->render('cursus/new.html.twig', array(
            'cursus' => $cursus,'classes'=>$listeClasses,'cursu'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cursus entity.
     *
     */
    public function showAction(Cursus $cursus)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($cursus);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('cursus/show.html.twig', array(
            'cursus' => $cursus,'classes'=>$listeClasses,'cursu'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cursus entity.
     *
     */
    public function editAction(Request $request, Cursus $cursus)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($cursus);
        $editForm = $this->createForm('AppBundle\Form\CursusType', $cursus);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cursus_edit', array('id' => $cursus->getId(),'classes'=>$listeClasses,'cursu'=>$listeCursus,));
        }

        return $this->render('cursus/edit.html.twig', array(
            'cursus' => $cursus,'classes'=>$listeClasses,'cursu'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cursus entity.
     *
     */
    public function deleteAction(Request $request, Cursus $cursus)
    {
        $form = $this->createDeleteForm($cursus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cursus);
            $em->flush();
        }

        return $this->redirectToRoute('cursus_index');
    }

    /**
     * Creates a form to delete a cursus entity.
     *
     * @param Cursus $cursus The cursus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cursus $cursus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cursus_delete', array('id' => $cursus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
