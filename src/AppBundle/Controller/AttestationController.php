<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attestation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Attestation controller.
 *
 */
class AttestationController extends Controller
{
    /**
     * Lists all attestation entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $attestations=array();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        if (($request->query->getAlnum('etat'))||($request->query->getAlnum('etudiant'))||($request->query->getAlnum('type')))
        {

            if (($request->query->getAlnum('etat'))&&($request->query->getAlnum('etudiant'))&&($request->query->getAlnum('type'))) {


                    if (($request->query->getAlnum('etat'))=="Encours"){
                        if(($request->query->getAlnum('type'))=="deprsence"){

                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom= LIKE :etudiant AND p.type=:type ")
                            ->setParameter('etat',"En cours")
                            ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                            ->setParameter('type',"de présence")
                            ->getResult();
                    }else{
                            $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom= LIKE :etudiant AND p.type=:type ")
                                ->setParameter('etat',"En cours")
                                ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                                ->setParameter('type',utf8_encode ( "d'inscription" ))
                                ->getResult();
                        }

                    }
                    else{
                        if(($request->query->getAlnum('type'))=="deprsence"){
                            $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom LIKE :etudiant AND p.type=:type  ")
                                ->setParameter('etat',"Prête")
                                ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                                ->setParameter('type',"de présence")
                                ->getResult();
                        }
                        else{
                            $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom LIKE :etudiant AND p.type=:type  ")
                                ->setParameter('etat',"Prête")
                                ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                                ->setParameter('type',utf8_encode ( "d'inscription" ))
                                ->getResult();
                        }

                    }



            } elseif (($request->query->getAlnum('etat'))&&($request->query->getAlnum('etudiant'))) {


            if (($request->query->getAlnum('etat'))=="Encours"){


                    $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom= LIKE :etudiant")
                        ->setParameter('etat',"En cours")
                        ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                        ->getResult();
            }
            else{
                    $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom LIKE :etudiant")
                        ->setParameter('etat',"Prête")
                        ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                        ->getResult();
            }



        } elseif (($request->query->getAlnum('etat'))&&($request->query->getAlnum('type'))){

                if (($request->query->getAlnum('etat'))=="Encours"){
                    if(($request->query->getAlnum('type'))=="deprsence"){

                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.type=:type ")
                            ->setParameter('etat',"En cours")

                            ->setParameter('type',"de présence")
                            ->getResult();
                    }else{
                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.type=:type ")
                            ->setParameter('etat',"En cours")

                            ->setParameter('type',utf8_encode ( "d'inscription" ))
                            ->getResult();
                    }

                }
                else{
                    if(($request->query->getAlnum('type'))=="deprsence"){
                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.type=:type  ")
                            ->setParameter('etat',"Prête")
                            ->setParameter('type',"de présence")
                            ->getResult();
                    }
                    else{
                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.type=:type  ")
                            ->setParameter('etat',"Prête")
                            ->setParameter('type',utf8_encode ( "d'inscription" ))
                            ->getResult();
                    }

                }

            }
            elseif (($request->query->getAlnum('etudiant'))&&($request->query->getAlnum('type'))){


                    if(($request->query->getAlnum('type'))=="deprsence"){

                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom= LIKE :etudiant AND p.type=:type ")

                            ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                            ->setParameter('type',"de présence")
                            ->getResult();
                    }else{
                        $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat AND p.nom= LIKE :etudiant AND p.type=:type ")

                            ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%" )
                            ->setParameter('type',utf8_encode ( "d'inscription" ))
                            ->getResult();
                    }
            }

            elseif (($request->query->getAlnum('etat')))

            {
            if (($request->query->getAlnum('etat'))=="Encours"){
                $m = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat")
                    ->setParameter('etat',"En cours");
                $attestations= $m->getResult();
            }
                else{
                    $m = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.etat=:etat")
                        ->setParameter('etat',"Prête");
                    $attestations= $m->getResult();
                }

            }
            elseif (($request->query->getAlnum('etudiant')))

            {
                    $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.nom LIKE :etudiant ")
                        ->setParameter('etudiant',"%".$request->query->getAlnum('etudiant')."%")
                        ->getResult();


            }
            elseif (($request->query->getAlnum('type')))

            {
                if(($request->query->getAlnum('type'))=="deprsence"){
                    $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.type=:type ")
                        ->setParameter('type',"de présence")
                        ->getResult();
                }
                else{

                    $attestations = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.type=:type ")
                        ->setParameter('type',utf8_encode ( "d'inscription" ))
                        ->getResult();
                }

            }

        } else{
            $attestations = $em->getRepository('AppBundle:Attestation')->findAll();

        }




        return $this->render('attestation/index.html.twig', array(
            'attestations' => $attestations,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new attestation entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $attestation = new Attestation();
        $form = $this->createForm('AppBundle\Form\AttestationType', $attestation);
        $form->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {
            $attestation->setEtat("En cours");

            $em->persist($attestation);
            $em->flush();

            return $this->redirectToRoute('attestation_show3', array('id' => $attestation->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('attestation/new.html.twig', array(
            'attestation' => $attestation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a attestation entity.
     *
     */
    public function showAction(Attestation $attestation)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($attestation);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('attestation/show.html.twig', array(
            'attestation' => $attestation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing attestation entity.
     *
     */
    public function editAction(Request $request, Attestation $attestation)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($attestation);
        $editForm = $this->createForm('AppBundle\Form\AttestationType', $attestation);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attestation_edit', array('id' => $attestation->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('attestation/edit.html.twig', array(
            'attestation' => $attestation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a attestation entity.
     *
     */
    public function deleteAction(Request $request, Attestation $attestation)
    {
        $form = $this->createDeleteForm($attestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($attestation);
            $em->flush();
        }

        return $this->redirectToRoute('attestation_index');
    }

    public function delete2Action(Request $request, Attestation $attestation)
    {
        $form = $this->createDeleteForm($attestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($attestation);
            $em->flush();
        }

        return $this->redirectToRoute('attestation_new');
    }


    /**
     * Creates a form to delete a attestation entity.
     *
     * @param Attestation $attestation The attestation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Attestation $attestation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('attestation_delete', array('id' => $attestation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function createDeleteForm2(Attestation $attestation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('attestation_delete2', array('id' => $attestation->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    public function validateAction(Attestation $attestation)
    {
        $deleteForm = $this->createDeleteForm($attestation);
        $attestation->setEtat("Prête");
        $em = $this->getDoctrine()->getManager();
        $em->persist($attestation);
        $em->flush();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('attestation/show.html.twig', array(
            'attestation' => $attestation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function show2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        $objetuser = $this->getUser();
        $User=$objetuser->getUsername();
        $resUser = $em->createQuery(" SELECT p FROM AppBundle:Attestation p WHERE p.nom=:nom")->setParameter('nom',$User)->getResult();



        return $this->render('attestation/show2.html.twig', array(
            'attestations' => $resUser,'classes'=>$listeClasses,'cursus'=>$listeCursus,

        ));
    }
    public function show3Action(Attestation $attestation)
    {

        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm2($attestation);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('attestation/show3.html.twig', array(
            'attestation' => $attestation,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
