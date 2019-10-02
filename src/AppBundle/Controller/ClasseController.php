<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Classe controller.
 *
 */
class ClasseController extends Controller
{
    /**
     * Lists all classe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $classes = $em->getRepository('AppBundle:Classe')->findAll();

        return $this->render('classe/index.html.twig', array(
            'classess' => $classes,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new classe entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = new Classe();
        $form = $this->createForm('AppBundle\Form\ClasseType', $classe);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('classe_show', array('id' => $classe->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus));
        }

        return $this->render('classe/new.html.twig', array(
            'classe' => $classe,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a classe entity.
     *
     */
    public function showAction(Classe $classe)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($classe);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('classe/show.html.twig', array(
            'classe' => $classe,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing classe entity.
     *
     */
    public function editAction(Request $request, Classe $classe)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($classe);
        $editForm = $this->createForm('AppBundle\Form\ClasseType', $classe);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_edit', array('id' => $classe->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('classe/edit.html.twig', array(
            'classe' => $classe,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a classe entity.
     *
     */
    public function deleteAction(Request $request, Classe $classe)
    {
        $form = $this->createDeleteForm($classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classe);
            $em->flush();
        }

        return $this->redirectToRoute('classe_index');
    }

    /**
     * Creates a form to delete a classe entity.
     *
     * @param Classe $classe The classe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Classe $classe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classe_delete', array('id' => $classe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
