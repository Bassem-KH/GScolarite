<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evaluation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evaluation controller.
 *
 */
class EvaluationController extends Controller
{
    /**
     * Lists all evaluation entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evaluations=array();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if (($request->query->getAlnum('type'))||($request->query->getAlnum('classe'))||($request->query->getAlnum('etudiant'))||($request->query->getAlnum('matiere'))) {

            $qClasse = $em->createQuery(" SELECT p.id FROM AppBundle:Classe p WHERE p.nom LIKE :nom")->setParameter('nom','%'.$request->query->getAlnum('classe').'%');
            $ResClasse= $qClasse->getResult();


            $qMatiere = $em->createQuery(" SELECT p.id FROM AppBundle:Matiere p WHERE p.nom LIKE :nom")->setParameter('nom','%'.$request->query->getAlnum('matiere').'%');
            $ResMatiere= $qMatiere->getResult();


            $qEtudiant = $em->createQuery(" SELECT p.id FROM AppBundle:Etudiant p WHERE p.nom LIKE :nom")->setParameter('nom','%'.$request->query->getAlnum('etudiant').'%');
            $ResEtudiant= $qEtudiant->getResult();


            if (($request->query->getAlnum('type'))&&($request->query->getAlnum('classe'))&&($request->query->getAlnum('etudiant'))&&($request->query->getAlnum('matiere'))) {


                foreach($ResClasse as $ligne) {

                    $idClasse = $ligne['id'];
                    foreach ($ResEtudiant as $ligne2) {
                        $idEtudiant = $ligne2['id'];
                        foreach ($ResMatiere as $ligne3) {
                            $idMatiere = $ligne3['id'];

                            $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type AND p.classe=:classe AND p.matiere=:matiere AND p.etudiant=:etudiant ")
                                ->setParameter('type','%'.$request->query->getAlnum('type').'%')
                                ->setParameter('classe',$idClasse)
                                ->setParameter('matiere',$idMatiere)
                                ->setParameter('etudiant',$idEtudiant)
                                ->getResult();

                            foreach($m as $evaluation){
                                $evaluations[] = array(
                                    "id" => $evaluation->getId(),
                                    "type"=>$evaluation->getType(),
                                    "etudiant"=>$evaluation->getEtudiant(),
                                    "classe"=>$evaluation->getClasse(),
                                    "matiere"=>$evaluation->getMatiere(),
                                    "note"=>$evaluation->getNote(),
                                );}
                        }
                    }
                }
            }

            elseif (($request->query->getAlnum('type'))&&($request->query->getAlnum('classe'))&&($request->query->getAlnum('etudiant')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResEtudiant as $ligne2){
                        $idEtudiant=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type AND p.classe=:classe AND p.etudiant=:etudiant ")
                            ->setParameter('type','%'.$request->query->getAlnum('type').'%')
                            ->setParameter('classe',$idClasse)
                            ->setParameter('etudiant',$idEtudiant)
                            ->getResult();

                        foreach($m as $evaluation){

                            $evaluations[] = array(
                                "id" => $evaluation->getId(),
                                "date"=>$evaluation->getDate(),
                                "etudiant"=>$evaluation->getEtudiant(),
                                "classe"=>$evaluation->getClasse(),
                                "matiere"=>$evaluation->getMatiere(),

                            );}

                    }

                }
            }

            elseif (($request->query->getAlnum('type'))&&($request->query->getAlnum('classe'))&&($request->query->getAlnum('matiere')))

            {

                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResMatiere as $ligne2){
                        $idMatiere=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type AND p.classe=:classe AND p.matiere=:matiere ")
                            ->setParameter('type','%'.$request->query->getAlnum('type').'%')
                            ->setParameter('classe',$idClasse)
                            ->setParameter('matiere',$idMatiere)
                            ->getResult();

                        foreach($m as $evaluation){

                            $evaluations[] = array(
                                "id" => $evaluation->getId(),
                                "date"=>$evaluation->getDate(),
                                "etudiant"=>$evaluation->getEtudiant(),
                                "classe"=>$evaluation->getClasse(),
                                "matiere"=>$evaluation->getMatiere(),

                            );}

                    }

                }
            }
            elseif (($request->query->getAlnum('etudiant'))&&($request->query->getAlnum('classe'))&&($request->query->getAlnum('matiere')))

            {
                foreach($ResClasse as $ligne) {

                    $idClasse = $ligne['id'];
                    foreach ($ResEtudiant as $ligne2) {
                        $idEtudiant = $ligne2['id'];
                        foreach ($ResMatiere as $ligne3) {
                            $idMatiere = $ligne3['id'];

                            $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.etudiant=:etudiant AND p.classe=:classe AND p.matiere=:matiere ")
                                ->setParameter('etudiant',$idEtudiant)
                                ->setParameter('classe',$idClasse)
                                ->setParameter('matiere',$idMatiere)
                                ->getResult();

                            foreach($m as $evaluation){
                                $evaluations[] = array(
                                    "id" => $evaluation->getId(),
                                    "type"=>$evaluation->getType(),
                                    "etudiant"=>$evaluation->getEtudiant(),
                                    "classe"=>$evaluation->getClasse(),
                                    "matiere"=>$evaluation->getMatiere(),
                                    "note"=>$evaluation->getNote(),
                                );}
                        }
                    }
                }
            }
            elseif (($request->query->getAlnum('type'))&&($request->query->getAlnum('classe')))

            {
                foreach($ResClasse as $ligne){
                    $idClasse=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type AND p.classe=:classe  ")
                        ->setParameter('type','%'.$request->query->getAlnum('type').'%')
                        ->setParameter('classe',$idClasse)
                        ->getResult();
                    foreach($m as $evaluation){
                        $evaluations[] = array(
                            "id" => $evaluation->getId(),
                            "type"=>$evaluation->getType(),
                            "etudiant"=>$evaluation->getEtudiant(),
                            "classe"=>$evaluation->getClasse(),
                            "matiere"=>$evaluation->getMatiere(),
                            "note"=>$evaluation->getNote(),
                        );}
                }
            }
            elseif (($request->query->getAlnum('type'))&&($request->query->getAlnum('matiere')))

            {
                foreach($ResMatiere as $ligne){
                    $idMatiere=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type AND p.etudiant=:etudiant  ")
                        ->setParameter('type','%'.$request->query->getAlnum('type').'%')
                        ->setParameter('etudiant',$idMatiere)
                        ->getResult();
                    foreach($m as $evaluation){
                        $evaluations[] = array(
                            "id" => $evaluation->getId(),
                            "type"=>$evaluation->getType(),
                            "etudiant"=>$evaluation->getEtudiant(),
                            "classe"=>$evaluation->getClasse(),
                            "matiere"=>$evaluation->getMatiere(),
                            "note"=>$evaluation->getNote(),
                        );}
                }

            }
            elseif (($request->query->getAlnum('type'))&&($request->query->getAlnum('etudiant')))

            {
                foreach($ResEtudiant as $ligne){
                    $idEtudiant=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type AND p.etudiant=:etudiant  ")
                        ->setParameter('type','%'.$request->query->getAlnum('type').'%')
                        ->setParameter('etudiant',$idEtudiant)
                        ->getResult();
                    foreach($m as $evaluation){
                        $evaluations[] = array(
                            "id" => $evaluation->getId(),
                            "type"=>$evaluation->getType(),
                            "etudiant"=>$evaluation->getEtudiant(),
                            "classe"=>$evaluation->getClasse(),
                            "matiere"=>$evaluation->getMatiere(),
                            "note"=>$evaluation->getNote(),
                        );}
                }

            }
            elseif (($request->query->getAlnum('classe'))&&($request->query->getAlnum('matiere')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResMatiere as $ligne2){
                        $idMatiere=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.classe=:classe AND p.matiere=:matiere  ")
                            ->setParameter('classe',$idClasse)
                            ->setParameter('matiere',$idMatiere)
                            ->getResult();

                        foreach($m as $evaluation){

                            $evaluations[] = array(
                                "id" => $evaluation->getId(),
                                "date"=>$evaluation->getDate(),
                                "etudiant"=>$evaluation->getEtudiant(),
                                "classe"=>$evaluation->getClasse(),
                                "matiere"=>$evaluation->getMatiere(),

                            );}

                    }

                }
            }
            elseif (($request->query->getAlnum('classe'))&&($request->query->getAlnum('etudiant')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    foreach($ResEtudiant as $ligne2){
                        $idEtudiant=$ligne2['id'];

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.classe=:classe AND p.etudiant=:etudiant  ")
                            ->setParameter('classe',$idClasse)
                            ->setParameter('etudiant',$idEtudiant)
                            ->getResult();

                        foreach($m as $evaluation){

                            $evaluations[] = array(
                                "id" => $evaluation->getId(),
                                "date"=>$evaluation->getDate(),
                                "etudiant"=>$evaluation->getEtudiant(),
                                "classe"=>$evaluation->getClasse(),
                                "matiere"=>$evaluation->getMatiere(),

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

                        $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.etudiant=:etudiant AND p.matiere=:matiere  ")
                            ->setParameter('etudiant',$idEtudiant)
                            ->setParameter('matiere',$idMatiere)
                            ->getResult();


                        foreach($m as $evaluation){


                            $evaluations[] = array(
                                "id" => $evaluation->getId(),
                                "date"=>$evaluation->getDate(),
                                "etudiant"=>$evaluation->getEtudiant(),
                                "classe"=>$evaluation->getClasse(),
                                "matiere"=>$evaluation->getMatiere(),

                            );}
                    }
                }



            }
            elseif (($request->query->getAlnum('type')))

            {
                $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.type LIKE :type")
                    ->setParameter('type','%'.$request->query->getAlnum('type').'%');
                $evaluations  = $m->getResult();
            }
            elseif (($request->query->getAlnum('classe')))

            {
                foreach($ResClasse as $ligne){

                    $idClasse=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.classe=:classe ")
                        ->setParameter('classe',$idClasse)
                        ->getResult();
                    foreach($m as $evaluation){
                        $evaluations[] = array(
                            "id" => $evaluation->getId(),
                            "type"=>$evaluation->getType(),
                            "etudiant"=>$evaluation->getEtudiant(),
                            "classe"=>$evaluation->getClasse(),
                            "matiere"=>$evaluation->getMatiere(),
                            "note"=>$evaluation->getNote(),

                        );}

                }
            }
            elseif (($request->query->getAlnum('matiere')))

            {
                foreach($ResMatiere as $ligne){

                    $idMatiere=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.matiere=:matiere ")
                        ->setParameter('matiere',$idMatiere)
                        ->getResult();
                    foreach($m as $evaluation){
                        $evaluations[] = array(
                            "id" => $evaluation->getId(),
                            "type"=>$evaluation->getType(),
                            "etudiant"=>$evaluation->getEtudiant(),
                            "classe"=>$evaluation->getClasse(),
                            "matiere"=>$evaluation->getMatiere(),
                            "note"=>$evaluation->getNote(),
                        );}
                }

            }

            elseif (($request->query->getAlnum('etudiant')))

            {
                foreach($ResEtudiant as $ligne){
                    $idEtudiant=$ligne['id'];
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.etudiant=:etudiant ")
                        ->setParameter('etudiant',$idEtudiant)
                        ->getResult();
                    foreach($m as $evaluation){
                        $evaluations[] = array(
                            "id" => $evaluation->getId(),
                            "type"=>$evaluation->getType(),
                            "etudiant"=>$evaluation->getEtudiant(),
                            "classe"=>$evaluation->getClasse(),
                            "matiere"=>$evaluation->getMatiere(),
                            "note"=>$evaluation->getNote(),
                        );}
                }
            }

        } else{$evaluations = $em->getRepository('AppBundle:Evaluation')->findAll();}




        return $this->render('evaluation/index.html.twig', array(
            'evaluations' => $evaluations,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new evaluation entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evaluation = new Evaluation();
        $form = $this->createForm('AppBundle\Form\EvaluationType', $evaluation);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {

            $etudiant=$this->toString($evaluation);
            $typeEva=$this->toString2($evaluation);
            $matiere=$this->toString3($evaluation);
            $classe=$this->toString4($evaluation);



            $m = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.etudiant=:nom AND p.type=:type AND p.matiere=:mat AND p.classe=:classe")
                ->setParameter('nom',$etudiant)
                ->setParameter('type',$typeEva)
                ->setParameter('mat',$matiere)
                ->setParameter('classe',$classe);
            $Res=$m->getResult();

            if(!$Res){
                $em->persist($evaluation);
                $em->flush();
                return $this->redirectToRoute('evaluation_show', array('id' => $evaluation->getId()));

            } else{
                $msg="Cet étudiant à déja une note ".$typeEva."";
                return $this->render('evaluation/new2.html.twig', array(
                    'evaluation' => $evaluation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
                    'form' => $form->createView(),'msg'=>$msg
                ));

            }

        }

        return $this->render('evaluation/new.html.twig', array(
            'evaluation' => $evaluation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a evaluation entity.
     *
     */
    public function showAction(Evaluation $evaluation)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($evaluation);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('evaluation/show.html.twig', array(
            'evaluation' => $evaluation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evaluation entity.
     *
     */
    public function editAction(Request $request, Evaluation $evaluation)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($evaluation);
        $editForm = $this->createForm('AppBundle\Form\EvaluationType', $evaluation);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_edit', array('id' => $evaluation->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('evaluation/edit.html.twig', array(
            'evaluation' => $evaluation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evaluation entity.
     *
     */
    public function deleteAction(Request $request, Evaluation $evaluation)
    {
        $form = $this->createDeleteForm($evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evaluation);
            $em->flush();
        }

        return $this->redirectToRoute('evaluation_index');
    }

    /**
     * Creates a form to delete a evaluation entity.
     *
     * @param Evaluation $evaluation The evaluation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evaluation $evaluation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evaluation_delete', array('id' => $evaluation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function toString($object)
    {
        return $object instanceof Evaluation
            ? $object->getEtudiant()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString2($object)
    {
        return $object instanceof Evaluation
            ? $object->getType()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString3($object)
    {
        return $object instanceof Evaluation
            ? $object->getMatiere()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString4($object)
    {
        return $object instanceof Evaluation
            ? $object->getClasse()
            : ''; // shown in the breadcrumb on the create view
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

    public function listModulesOfCursusAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $modulesRepository = $em->getRepository("AppBundle:Module");

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $modules = $modulesRepository->createQueryBuilder("q")
            ->where("q.cursus = :cursusid")
            ->setParameter("cursusid", $request->query->get("cursusid"))
            ->getQuery()
            ->getResult();


        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($modules as $module){
            $responseArray[] = array(
                "id" => $module->getId(),
                "name" => $module->getNom()
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

    public function show2Action(){

        $em = $this->getDoctrine()->getManager();
        $notesArray =array();
        $notesArray2 =array();
        $matiereArray=array();

        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $objetuser = $this->getUser();
        $User=$objetuser->getUsername();
        $resUser = $em->createQuery(" SELECT p.id FROM AppBundle:Etudiant p WHERE p.nom=:nom")->setParameter('nom',$User)->getResult();
        $idUser = $resUser[0]['id'];

        $query = $em->createQueryBuilder();

        $query->select('DISTINCT pa.id')
            ->from('AppBundle:Evaluation', 'ca')
            ->where('ca.etudiant=:id');
        $query->join('ca.matiere', 'pa')->setParameter('id',$idUser);

        $res = $query->getQuery()->getArrayResult();
        foreach($res as $ligne){

            $idMat=$ligne['id'];
            $ResNomMat = $em->createQuery(" SELECT p FROM AppBundle:Matiere p WHERE p.id=:id")->setParameter('id',$idMat)->getResult();

            foreach($ResNomMat as $matiere){
                $matiereArray[] = array(
                    "nom" => $matiere->getNom(),
                  //  "nbMax"=>$matiere->getNombreAbsences(),
                );}
          //  $resNote = $em->createQuery(" SELECT DISTINCT IDENTITY(p.matiere)  FROM AppBundle:Evaluation p WHERE p.matiere=:id AND p.etudiant=:etu")->setParameter('id',$idMat)->setParameter('etu',$idUser)->getResult();
            $resNote2 = $em->createQuery(" SELECT p FROM AppBundle:Evaluation p WHERE p.matiere=:id AND p.etudiant=:etu ORDER BY p.type")->setParameter('id',$idMat)->setParameter('etu',$idUser)->getResult();
/*var_dump($resNote);
            foreach($resNote as $notes){

                $notesArray[] = array(

                    "matiere" => $notes[1],

                    //  "nbMax"=>$matiere->getNombreAbsences(),
                );}*/

            foreach($resNote2 as $n){
                $notesArray2[] = array(
                    "note" => $n->getNote(),
                    "matiere" => $n->getMatiere(),
                    "type" => $n->getType(),
                    //  "nbMax"=>$matiere->getNombreAbsences(),
                );}
        }
        return $this->render('evaluation/show2.html.twig', array('res'=>$matiereArray,'notes'=>$notesArray,'test'=>$notesArray2,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }
}
