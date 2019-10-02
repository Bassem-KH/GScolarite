<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Matiere controller.
 *
 */
class MatiereController extends Controller
{
    /**
     * Lists all matiere entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $matieres = $em->getRepository('AppBundle:Matiere')->findAll();

        return $this->render('matiere/index.html.twig', array(
            'matieres' => $matieres,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new matiere entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $matiere = new Matiere();
        $form = $this->createForm('AppBundle\Form\MatiereType', $matiere);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($matiere);
            $em->flush();

            return $this->redirectToRoute('matiere_show', array('id' => $matiere->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('matiere/new.html.twig', array(
            'matiere' => $matiere,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a matiere entity.
     *
     */
    public function showAction(Matiere $matiere)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($matiere);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('matiere/show.html.twig', array(
            'matiere' => $matiere,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing matiere entity.
     *
     */
    public function editAction(Request $request, Matiere $matiere)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($matiere);
        $editForm = $this->createForm('AppBundle\Form\MatiereType', $matiere);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matiere_edit', array('id' => $matiere->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('matiere/edit.html.twig', array(
            'matiere' => $matiere,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a matiere entity.
     *
     */
    public function deleteAction(Request $request, Matiere $matiere)
    {
        $form = $this->createDeleteForm($matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($matiere);
            $em->flush();
        }

        return $this->redirectToRoute('matiere_index');
    }

    /**
     * Creates a form to delete a matiere entity.
     *
     * @param Matiere $matiere The matiere entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Matiere $matiere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matiere_delete', array('id' => $matiere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function listModulesOfCursusAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $modulesRepository = $em->getRepository("AppBundle:Module");


        $modules = $modulesRepository->createQueryBuilder("q")
            ->where("q.cursus = :cursusid")
            ->setParameter("cursusid", $request->query->get("cursusid"))
            ->getQuery()
            ->getResult();


        $responseArray = array();
        foreach($modules as $module){
            $responseArray[] = array(
                "id" => $module->getId(),
                "name" => $module->getNom()
            );

        }

        return new JsonResponse($responseArray);

    }
}
