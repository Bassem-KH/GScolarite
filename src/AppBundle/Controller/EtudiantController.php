<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classe;
use AppBundle\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Etudiant controller.
 *
 */
class EtudiantController extends Controller
{
    /**
     * Lists all etudiant entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        $etudiants=array();
        if (($request->query->getAlnum('classe'))||($request->query->getAlnum('etudiant')))
        {   $qClasse = $em->createQuery(" SELECT p.id FROM AppBundle:Classe p WHERE p.nom LIKE :nom")
            ->setParameter('nom','%'.$request->query->getAlnum('classe').'%');
            $ResClasse= $qClasse->getResult();
            $qEtudiant = $em->createQuery(" SELECT p.id FROM AppBundle:Etudiant p WHERE p.nom LIKE :nom")
                ->setParameter('nom','%'.$request->query->getAlnum('etudiant').'%');
            $ResEtudiant= $qEtudiant->getResult();
            if (($request->query->getAlnum('classe'))&&($request->query->getAlnum('etudiant')))

        {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResEtudiant as $ligne2){
                        $idEtudiant=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Etudiant p WHERE p.classe=:classe AND p.id=:etudiant ")
                            ->setParameter('classe',$idClasse)
                            ->setParameter('etudiant',$idEtudiant)
                            ->getResult();

                        foreach($m as $etudiant){

                            $etudiants[] = array(
                                "id" => $etudiant->getId(),
                                "nom"=>$etudiant->getNom(),
                                "classe"=>$etudiant->getClasse(),


                            );}

                    }

                }
            } elseif (($request->query->getAlnum('classe')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Etudiant p WHERE p.classe=:classe ")
                        ->setParameter('classe',$idClasse)
                        ->getResult();
                    foreach($m as $etudiant){
                        $etudiants[] = array(
                            "id" => $etudiant->getId(),

                            "nom"=>$etudiant->getNom(),
                            "classe"=>$etudiant->getClasse(),


                        );}

                }

            }elseif (($request->query->getAlnum('etudiant')))

            {
                foreach($ResEtudiant as $ligne){

                    $idEtudiant=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:etudiant p WHERE p.id=:etudiant ")
                        ->setParameter('etudiant',$idEtudiant)
                        ->getResult();
                    foreach($m as $etudiant){
                        $etudiants[] = array(
                            "id" => $etudiant->getId(),

                            "nom"=>$etudiant->getNom(),
                            "classe"=>$etudiant->getClasse(),


                        );}

                }

            }

        }
        else{
            $etudiants = $em->getRepository('AppBundle:Etudiant')->findAll();
        }


        return $this->render('etudiant/index.html.twig', array(
            'etudiants' => $etudiants,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new etudiant entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $etudiant = new Etudiant();
        $form = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($etudiant);
            $em->flush();

            $classe=$this->toString($etudiant);
            $nom_classe=$this->toString2($classe);
            $idd=$this->toString3($classe);

            //$nombre=0;
            $m = $em->createQuery(" SELECT p.nbrEtudiants FROM AppBundle:Classe p WHERE p.id=:nom")->setParameter('nom',$idd);
           $test= $m->getResult();

           $test2=$test[0]['nbrEtudiants'];
           $nombre=$test2+1;

            $qb = $em->createQueryBuilder();
            $q = $qb->update('AppBundle:Classe', 'u')
                ->set('u.nbrEtudiants',$nombre)

                ->where('u.id = ?1')
                ->setParameter(1, $idd)

                ->getQuery();
            $p = $q->execute();
            return $this->redirectToRoute('etudiant_show', array('id' => $etudiant->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('etudiant/new.html.twig', array(
            'etudiant' => $etudiant,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a etudiant entity.
     *
     */
    public function showAction(Etudiant $etudiant)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($etudiant);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('etudiant/show.html.twig', array(
            'etudiant' => $etudiant,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing etudiant entity.
     *
     */
    public function editAction(Request $request, Etudiant $etudiant)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($etudiant);
        $editForm = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_edit', array('id' => $etudiant->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('etudiant/edit.html.twig', array(
            'etudiant' => $etudiant,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etudiant entity.
     *
     */
    public function deleteAction(Request $request, Etudiant $etudiant)
    {
        $form = $this->createDeleteForm($etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();

            $classe=$this->toString($etudiant);
            $nom_classe=$this->toString2($classe);
            $idd=$this->toString3($classe);

            //$nombre=0;
            $m = $em->createQuery(" SELECT p.nbrEtudiants FROM AppBundle:Classe p WHERE p.id=:nom")->setParameter('nom',$idd);
            $test= $m->getResult();

            $test2=$test[0]['nbrEtudiants'];
            $nombre=$test2-1;

            $qb = $em->createQueryBuilder();
            $q = $qb->update('AppBundle:Classe', 'u')
                ->set('u.nbrEtudiants',$nombre)

                ->where('u.id = ?1')
                ->setParameter(1, $idd)

                ->getQuery();
            $p = $q->execute();
        }

        return $this->redirectToRoute('etudiant_index');
    }

    /**
     * Creates a form to delete a etudiant entity.
     *
     * @param Etudiant $etudiant The etudiant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etudiant $etudiant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etudiant_delete', array('id' => $etudiant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function toString($object)
    {
        return $object instanceof Etudiant
            ? $object->getClasse()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString2($object)
    {
        return $object instanceof Classe
            ? $object->getNom()
            : ''; // shown in the breadcrumb on the create view
    }

    public function toString3($object)
    {
        return $object instanceof Classe
            ? $object->getId()
            : ''; // shown in the breadcrumb on the create view
    }



    /**
     * Returns a JSON string with the neighborhoods of the City with the providen id.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listClassesOfCursusAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $classesRepository = $em->getRepository("AppBundle:Classe");

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $classes = $classesRepository->createQueryBuilder("q")
            ->where("q.cursus = :cursusid")
            ->setParameter("cursusid", $request->query->get("cursusid"))
            ->getQuery()
            ->getResult();

        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($classes as $classe){
            $responseArray[] = array(
                "id" => $classe->getId(),
                "name" => $classe->getNom()
            );
        }

        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }

}
