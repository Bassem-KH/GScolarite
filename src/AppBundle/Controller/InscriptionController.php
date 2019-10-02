<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inscription controller.
 *
 */
class InscriptionController extends Controller
{
    /**
     * Lists all inscription entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();


        if (($request->query->getAlnum('type'))||($request->query->getAlnum('nom'))||($request->query->getAlnum('cin'))) {

            if (($request->query->getAlnum('type'))&&($request->query->getAlnum('nom'))) {


                $qNom = $em->createQuery(" SELECT p FROM AppBundle:Inscription p WHERE p.nom LIKE :nom OR p.prenom LIKE :nom AND p.etat=:type")
                    ->setParameter('nom','%'.$request->query->getAlnum('nom').'%')
                ->setParameter('type',$request->query->getAlnum('type'));
                $inscriptions= $qNom->getResult();

            }elseif (($request->query->getAlnum('type'))){
                    if($request->query->getAlnum('type')=="Accept"){
                        $qNom = $em->createQuery(" SELECT p FROM AppBundle:Inscription p WHERE p.etat=:etat")

                            ->setParameter('etat',"Accepté");
                        $inscriptions= $qNom->getResult();

                    }else{

                        $qNom = $em->createQuery(" SELECT p FROM AppBundle:Inscription p WHERE p.etat=:etat")

                            ->setParameter('etat',"En cours");
                        $inscriptions= $qNom->getResult();
                    }

            }
            elseif (($request->query->getAlnum('nom'))){

                $qNom = $em->createQuery(" SELECT p FROM AppBundle:Inscription p WHERE p.nom LIKE :nom OR p.prenom LIKE :nom")
                    ->setParameter('nom','%'.$request->query->getAlnum('nom').'%');
                $inscriptions= $qNom->getResult();
            }
            elseif (($request->query->getAlnum('cin'))){

                $qNom = $em->createQuery(" SELECT p FROM AppBundle:Inscription p WHERE p.cin=:cin")

                    ->setParameter('cin',$request->query->getAlnum('cin'));
                $inscriptions= $qNom->getResult();
            }

        } else{$inscriptions = $em->getRepository('AppBundle:Inscription')->findAll();}

        //$inscriptions = $em->getRepository('AppBundle:Inscription')->findAll();

        return $this->render('inscription/index.html.twig', array(
            'inscriptions' => $inscriptions,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new inscription entity.
     *
     */
    public function newAction(Request $request)
    {
        $inscription = new Inscription();
        $form = $this->createForm('AppBundle\Form\InscriptionType', $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $inscription->setEtat("En cours");


            $url='uploads/releves/';
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $inscription->getReleve();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $fileName=$url.$fileName;
            // Move the file to the directory where brochures are stored
            $RLVDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/releves';
            $file->move($RLVDir, $fileName);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $inscription->setReleve($fileName);
            $em->persist($inscription);
            $em->flush();
            return $this->redirectToRoute('inscription_show2', array('id' => $inscription->getId()));
        }

        return $this->render('inscription/new.html.twig', array(
            'inscription' => $inscription,
            'form' => $form->createView(),
        ));
    }
    public function validateAction(Inscription $inscription)
    {
        $deleteForm = $this->createDeleteForm($inscription);
        $inscription->setEtat("Accepté");
        $em = $this->getDoctrine()->getManager();
        $em->persist($inscription);
        $em->flush();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('inscription/show.html.twig', array(
            'inscription' => $inscription,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a inscription entity.
     *
     */
    public function showAction(Inscription $inscription)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($inscription);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('inscription/show.html.twig', array(
            'inscription' => $inscription,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function show2Action(Inscription $inscription)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($inscription);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('inscription/show2.html.twig', array(
            'inscription' => $inscription,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Displays a form to edit an existing inscription entity.
     *
     */
    public function editAction(Request $request, Inscription $inscription)
    {
        $deleteForm = $this->createDeleteForm($inscription);
        $editForm = $this->createForm('AppBundle\Form\InscriptionType', $inscription);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            $url='uploads/releves/';
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $inscription->getReleve();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $fileName=$url.$fileName;
            // Move the file to the directory where brochures are stored
            $RLVDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/releves';
            $file->move($RLVDir, $fileName);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $inscription->setReleve($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inscription_edit', array('id' => $inscription->getId()));
        }

        return $this->render('inscription/edit.html.twig', array(
            'inscription' => $inscription,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a inscription entity.
     *
     */
    public function deleteAction(Request $request, Inscription $inscription)
    {
        $form = $this->createDeleteForm($inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inscription);
            $em->flush();
        }

        return $this->redirectToRoute('inscription_index');
    }

    /**
     * Creates a form to delete a inscription entity.
     *
     * @param Inscription $inscription The inscription entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inscription $inscription)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inscription_delete', array('id' => $inscription->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function listCyclesOfSpecAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $cyclesRepository = $em->getRepository("AppBundle:Cycle");


        $cycles = $cyclesRepository->createQueryBuilder("q")
            ->where("q.specc = :speccid")
            ->setParameter("speccid", $request->query->get("speccid"))
            ->getQuery()
            ->getResult();


        $responseArray = array();
        foreach($cycles as $cycle){
            $responseArray[] = array(
                "id" => $cycle->getId(),
                "name" => $cycle->getNom()
            );

        }

        return new JsonResponse($responseArray);

    }



    public function etatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        if (($request->query->getAlnum('cin'))) {
            $qNom = $em->createQuery(" SELECT p FROM AppBundle:Inscription p WHERE p.cin=:cin")

                ->setParameter('cin',$request->query->getAlnum('cin'));
            $inscriptions= $qNom->getResult();

            if ($inscriptions){




                return $this->render('inscription/etat.html.twig', array(
                    'inscriptions' => $inscriptions,'msg'=>$msg=null
                ));

            }
            else{$msg="Demande introuvable";
            $inscriptions=null;

                return $this->render('inscription/etat.html.twig', array(
                    'inscriptions' => $inscriptions,'msg'=>$msg
                ));

            }
        } else{
            return $this->render('inscription/etat.html.twig', array(
                'inscriptions' => $inscriptions=null,'msg'=>$msg=null
            ));
        }




    }
}
