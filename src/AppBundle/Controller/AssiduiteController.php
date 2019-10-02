<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Assiduite;
use AppBundle\Entity\Classe;
use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Assiduite controller.
 *
 */
class AssiduiteController extends Controller
{
    /**
     * Lists all assiduite entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $assiduites=array();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        if (($request->query->getAlnum('classe'))||($request->query->getAlnum('etudiant'))||($request->query->getAlnum('matiere'))) {

            $qClasse = $em->createQuery(" SELECT p.id FROM AppBundle:Classe p WHERE p.nom LIKE :nom")->setParameter('nom','%'.$request->query->getAlnum('classe').'%');
            $ResClasse= $qClasse->getResult();

            //$idClasse=$ResClasse[0]['id'];

            $qMatiere = $em->createQuery(" SELECT p.id FROM AppBundle:Matiere p WHERE p.nom LIKE :nom")->setParameter('nom','%'.$request->query->getAlnum('matiere').'%');
            $ResMatiere= $qMatiere->getResult();
           // $idMatiere=$ResMatiere[0]['id'];

            $qEtudiant = $em->createQuery(" SELECT p.id FROM AppBundle:Etudiant p WHERE p.nom LIKE :nom")->setParameter('nom','%'.$request->query->getAlnum('etudiant').'%');
            $ResEtudiant= $qEtudiant->getResult();
         //   $idEtudiant=$ResEtudiant[0]['id'];

            if (($request->query->getAlnum('classe'))&&($request->query->getAlnum('etudiant'))&&($request->query->getAlnum('matiere'))) {

                foreach($ResClasse as $ligne) {

                    $idClasse = $ligne['id'];
                    foreach ($ResEtudiant as $ligne2) {
                        $idEtudiant = $ligne2['id'];
                        foreach ($ResMatiere as $ligne3) {
                            $idMatiere = $ligne3['id'];

                            $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.classe=:classe AND p.matiere=:matiere AND p.etudiant=:etudiant ")
                                ->setParameter('classe', $idClasse)
                                ->setParameter('matiere', $idMatiere)
                                ->setParameter('etudiant', $idEtudiant)
                                ->getResult();

                            foreach ($m as $assiduite) {

                                $assiduites[] = array(
                                    "id" => $assiduite->getId(),
                                    "date" => $assiduite->getDate(),
                                    "etudiant" => $assiduite->getEtudiant(),
                                    "classe" => $assiduite->getClasse(),
                                    "matiere" => $assiduite->getMatiere(),

                                );
                            }

                        }

                    }


                }
            }


            elseif (($request->query->getAlnum('classe'))&&($request->query->getAlnum('etudiant')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResEtudiant as $ligne2){
                        $idEtudiant=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.classe=:classe AND p.etudiant=:etudiant ")
                            ->setParameter('classe',$idClasse)
                            ->setParameter('etudiant',$idEtudiant)
                            ->getResult();

                        foreach($m as $assiduite){

                            $assiduites[] = array(
                                "id" => $assiduite->getId(),
                                "date"=>$assiduite->getDate(),
                                "etudiant"=>$assiduite->getEtudiant(),
                                "classe"=>$assiduite->getClasse(),
                                "matiere"=>$assiduite->getMatiere(),

                            );}

                    }

                }
            }




            elseif (($request->query->getAlnum('classe'))&&($request->query->getAlnum('matiere')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResMatiere as $ligne2){
                        $idMatiere=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.classe=:classe AND p.matiere=:matiere  ")
                            ->setParameter('classe',$idClasse)
                            ->setParameter('matiere',$idMatiere)
                            ->getResult();

                        foreach($m as $assiduite){

                            $assiduites[] = array(
                                "id" => $assiduite->getId(),
                                "date"=>$assiduite->getDate(),
                                "etudiant"=>$assiduite->getEtudiant(),
                                "classe"=>$assiduite->getClasse(),
                                "matiere"=>$assiduite->getMatiere(),

                            );}

                    }

                }

            }

            elseif (($request->query->getAlnum('etudiant'))&&($request->query->getAlnum('matiere')))

            {
                foreach($ResMatiere as $ligne){

                    $idMatiere=$ligne['id'];
                    foreach($ResEtudiant as $ligne2){
                        $idEtudiant=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.etudiant=:etudiant AND p.matiere=:matiere  ")
                            ->setParameter('etudiant',$idEtudiant)
                            ->setParameter('matiere',$idMatiere)
                        ->getResult();


                        foreach($m as $assiduite){


                            $assiduites[] = array(
                                "id" => $assiduite->getId(),
                                "date"=>$assiduite->getDate(),
                                "etudiant"=>$assiduite->getEtudiant(),
                                "classe"=>$assiduite->getClasse(),
                                "matiere"=>$assiduite->getMatiere(),

                            );}
                    }
                }
            }

            elseif (($request->query->getAlnum('classe')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.classe=:classe ")
                        ->setParameter('classe',$idClasse)
                        ->getResult();
                    foreach($m as $assiduite){
                        $assiduites[] = array(
                            "id" => $assiduite->getId(),
                            "date"=>$assiduite->getDate(),
                            "etudiant"=>$assiduite->getEtudiant(),
                            "classe"=>$assiduite->getClasse(),
                            "matiere"=>$assiduite->getMatiere(),

                        );}

                }

            }
            elseif (($request->query->getAlnum('matiere')))

            {
                foreach($ResMatiere as $ligne){

                    $idMatiere=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.matiere=:matiere ")
                        ->setParameter('matiere',$idMatiere)
                        ->getResult();
                    foreach($m as $assiduite){
                        $assiduites[] = array(
                            "id" => $assiduite->getId(),
                            "date"=>$assiduite->getDate(),
                            "etudiant"=>$assiduite->getEtudiant(),
                            "classe"=>$assiduite->getClasse(),
                            "matiere"=>$assiduite->getMatiere(),

                        );}
            }}

            elseif (($request->query->getAlnum('etudiant')))

            {
                foreach($ResEtudiant as $ligne){

                    $idEtudiant=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.etudiant=:etudiant ")
                        ->setParameter('etudiant',$idEtudiant)
                        ->getResult();
                    foreach($m as $assiduite){
                        $assiduites[] = array(
                            "id" => $assiduite->getId(),
                            "date"=>$assiduite->getDate(),
                            "etudiant"=>$assiduite->getEtudiant(),
                            "classe"=>$assiduite->getClasse(),
                            "matiere"=>$assiduite->getMatiere(),

                        );}

                }

            }

        } else{$assiduites = $em->getRepository('AppBundle:Assiduite')->findAll();}

        // $assiduites = $em->getRepository('AppBundle:Assiduite')->findAll();

        return $this->render('assiduite/index.html.twig', array(
            'assiduites' => $assiduites,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new assiduite entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $assiduite = new Assiduite();
        $form = $this->createForm('AppBundle\Form\AssiduiteType', $assiduite);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($assiduite);
            $em->flush();

            return $this->redirectToRoute('assiduite_show', array('id' => $assiduite->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('assiduite/new.html.twig', array(
            'assiduite' => $assiduite,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a assiduite entity.
     *
     */
    public function showAction(Assiduite $assiduite)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($assiduite);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        return $this->render('assiduite/show.html.twig', array(
            'assiduite' => $assiduite,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing assiduite entity.
     *
     */
    public function editAction(Request $request, Assiduite $assiduite)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($assiduite);
        $editForm = $this->createForm('AppBundle\Form\AssiduiteType', $assiduite);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('assiduite_edit', array('id' => $assiduite->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('assiduite/edit.html.twig', array(
            'assiduite' => $assiduite,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a assiduite entity.
     *
     */
    public function deleteAction(Request $request, Assiduite $assiduite)
    {
        $form = $this->createDeleteForm($assiduite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($assiduite);
            $em->flush();
        }

        return $this->redirectToRoute('assiduite_index');
    }

    /**
     * Creates a form to delete a assiduite entity.
     *
     * @param Assiduite $assiduite The assiduite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Assiduite $assiduite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('assiduite_delete', array('id' => $assiduite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

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
    public function listEtudiantsOfClasseAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $etudiantsRepository = $em->getRepository("AppBundle:Etudiant");

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $etudiants = $etudiantsRepository->createQueryBuilder("q")
            ->where("q.classe = :classeid")
            ->setParameter("classeid", $request->query->get("classeid"))
            ->getQuery()
            ->getResult();

        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($etudiants as $etudiant){
            $responseArray[] = array(
                "id" => $etudiant->getId(),
                "name" => $etudiant->getNom()
            );
        }

        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }



    public function listMatieresOfModuleAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $matieresRepository = $em->getRepository("AppBundle:Matiere");

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $matieres = $matieresRepository->createQueryBuilder("q")
            ->where("q.module = :moduleid")
            ->setParameter("moduleid", $request->query->get("moduleid"))
            ->getQuery()
            ->getResult();

        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($matieres as $matiere){
            $responseArray[] = array(
                "id" => $matiere->getId(),
                "name" => $matiere->getNom()
            );
        }

        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }

    public function show2Action()
    {        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $objetuser = $this->getUser();
        $User=$objetuser->getUsername();
        $resUser = $em->createQuery(" SELECT p.id FROM AppBundle:Etudiant p WHERE p.nom=:nom")->setParameter('nom',$User)->getResult();
        $idUser = $resUser[0]['id'];


       // $res = $em->createQuery(" SELECT p,DISTINCT (IDENTITY(p.etudiant)) FROM AppBundle:Assiduite p WHERE p.etudiant=:id")->setParameter('id',$idUser)->getResult();

        $query = $em->createQueryBuilder();

        $query->select('DISTINCT pa.id')
            ->from('AppBundle:Assiduite', 'ca')
            ->where('ca.etudiant=:id');
        $query->join('ca.matiere', 'pa')->setParameter('id',$idUser);

        $res = $query->getQuery()->getArrayResult();
        //$responseArray = array();
        $matiereArray = array();
        //$NomArray=array();
        foreach($res as $ligne){
            $idMat=$ligne['id'];
            $ResNomMat = $em->createQuery(" SELECT p FROM AppBundle:Matiere p WHERE p.id=:id")->setParameter('id',$idMat)->getResult();

            foreach($ResNomMat as $matiere){
            $matiereArray[] = array(
                "nom" => $matiere->getNom(),
                "nbMax"=>$matiere->getNombreAbsences(),
            );}

            $resMat = $em->createQuery(" SELECT COUNT (p),p FROM AppBundle:Assiduite p WHERE p.matiere=:id AND p.etudiant=:etu")->setParameter('id',$idMat)->setParameter('etu',$idUser)->getResult();

            //$NomMat = $em->createQuery(" SELECT p FROM AppBundle:Assiduite p WHERE p.matiere=:id AND p.etudiant=:etu")->setParameter('id',$idMat)->setParameter('etu',$idUser)->getResult();
         //   $ResNomMat2 = $em->createQuery(" SELECT p.nombreAbsences FROM AppBundle:Matiere p WHERE p.id=:id")->setParameter('id',$idMat)->getResult();
           // var_dump($resMat);
            $nbAbsencesArray[] = array(
                "nombre" => $resMat[0][1],
                "matiere"=>$resMat[0][0]->getMatiere(),
            );
/*

            $AbsenceArray[] = array(
                "absence" => $ResNomMat2[0]['nombreAbsences'],
            );*/
        }
        //  $matiere = $em->createQuery(" SELECT p DISTINCT IDENTITY (p.matiere) FROM AppBundle:Assiduite p WHERE p.classe=:id")->setParameter('id',$classe)->getResult();
       // $query = $em->createQueryBuilder();

        /*$query->select('DISTINCT pa.id')
            ->from('AppBundle:Assiduite', 'ca');
        $query->join('ca.matiere', 'pa');

        $result = $query->getQuery()->getArrayResult();*/

        return $this->render('assiduite/show2.html.twig', array('res'=>$matiereArray,'num'=>$nbAbsencesArray,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }


}
