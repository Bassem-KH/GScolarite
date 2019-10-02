<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classe;
use AppBundle\Entity\Enseignant;
use AppBundle\Entity\Seances;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Seance controller.
 *
 */
class SeancesController extends Controller
{
    /**
     * Lists all seance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $seances = $em->getRepository('AppBundle:Seances')->findAll();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();
        return $this->render('seances/index.html.twig', array(
            'seances' => $seances,'classes'=>$listeClasses,'cursus'=>$listeCursus,
        ));
    }

    /**
     * Creates a new seance entity.
     *
     */
    public function newAction(Request $request)
    {
        $seance = new Seances();
        $form = $this->createForm('AppBundle\Form\SeancesType', $seance);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($form->isSubmitted() && $form->isValid()) {


            $enseignant=$this->toString2($seance);
            $temps=$this->toString3($seance);
            $jour=$this->toString4($seance);
            $classe=$this->toString($seance);
            $salle=$this->toString5($seance);
            $m = $em->createQuery(" SELECT p.tempsDebut FROM AppBundle:Seances p WHERE p.enseignant=:nom AND p.tempsDebut=:temps AND p.jours=:jr")->setParameter('nom',$enseignant)->setParameter('temps',$temps)->setParameter('jr',$jour);
            $c=$em->createQuery(" SELECT p.tempsDebut FROM AppBundle:Seances p WHERE p.classe=:classe AND p.tempsDebut=:temps AND p.jours=:jr")->setParameter('classe',$classe)->setParameter('temps',$temps)->setParameter('jr',$jour);
            $s=$em->createQuery(" SELECT p.tempsDebut FROM AppBundle:Seances p WHERE p.salle=:salle AND p.tempsDebut=:temps AND p.jours=:jr")->setParameter('salle',$salle)->setParameter('temps',$temps)->setParameter('jr',$jour);


            //$tempsEnseignant=$m[0]['tempsDebut'];

         /*   $qb = $em->createQueryBuilder();
            $qb->select('u')
                ->from('AppBundle:Seances', 'u')
                ->andwhere('u.jours = ?3')
                ->andwhere('u.enseignant = ?1')
                ->andwhere('u.tempsDebut = ?2')
                ->setParameter(3,'Monday')
                ->setParameter(1, $enseignant)
                ->setParameter(2,$temps)
                ->getQuery()
                ->execute();*/
            $ens=$m->getResult();
            $clas=$c->getResult();
            $sal=$s->getResult();
            //var_dump($test);
            if(!$ens){
                if (!$clas){
                    if(!$sal){
                        $em->persist($seance);
                        $em->flush();
                        return $this->redirectToRoute('seances_show', array('id' => $seance->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus));}
                    else{
                        $msg="Salle occupé";
                        return $this->render('seances/new2.html.twig', array(
                            'seance' => $seance,'classes'=>$listeClasses,'cursus'=>$listeCursus,
                            'form' => $form->createView(),'msg'=>$msg
                        ));
                    }

                }else{
                    $msg="Classe occupé";
                    return $this->render('seances/new2.html.twig', array(
                        'seance' => $seance,'classes'=>$listeClasses,'cursus'=>$listeCursus,
                        'form' => $form->createView(),'msg'=>$msg
                    ));
                }

            }else{
                $msg="Enseignant occupé";
                return $this->render('seances/new2.html.twig', array(
                    'seance' => $seance,'classes'=>$listeClasses,'cursus'=>$listeCursus,
                    'form' => $form->createView(),'msg'=>$msg
                ));
            }




        }

        return $this->render('seances/new.html.twig', array(
            'seance' => $seance,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a seance entity.
     *
     */
    public function showAction(Seances $seance)
    { $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($seance);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('seances/show.html.twig', array(
            'seance' => $seance,'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing seance entity.
     *
     */
    public function editAction(Request $request, Seances $seance)
    {$em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($seance);
        $editForm = $this->createForm('AppBundle\Form\SeancesType', $seance);
        $editForm->handleRequest($request);
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seances_edit', array('id' => $seance->getId(),'classes'=>$listeClasses,'cursus'=>$listeCursus,));
        }

        return $this->render('seances/edit.html.twig', array(
            'seance' => $seance,
            'classes'=>$listeClasses,'cursus'=>$listeCursus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a seance entity.
     *
     */
    public function deleteAction(Request $request, Seances $seance)
    {
        $form = $this->createDeleteForm($seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($seance);
            $em->flush();
        }

        return $this->redirectToRoute('seances_index');
    }

    /**
     * Creates a form to delete a seance entity.
     *
     * @param Seances $seance The seance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Seances $seance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seances_delete', array('id' => $seance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function toString($object)
    {
        return $object instanceof Seances
            ? $object->getClasse()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString2($object)
    {
        return $object instanceof Seances
            ? $object->getEnseignant()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString3($object)
    {
        return $object instanceof Seances
            ? $object->getTempsDebut()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString4($object)
    {
        return $object instanceof Seances
            ? $object->getJours()
            : ''; // shown in the breadcrumb on the create view
    }
    public function toString5($object)
    {
        return $object instanceof Seances
            ? $object->getSalle()
            : ''; // shown in the breadcrumb on the create view
    }



    public function show2Action(Classe $classe)
    {        $em = $this->getDoctrine()->getManager();

        $monday = $em->createQuery(" SELECT p FROM AppBundle:Seances p WHERE p.classe=:id AND p.jours='Lundi' ORDER BY p.tempsDebut")->setParameter('id',$classe)->getResult();
        $tuesday = $em->createQuery(" SELECT p FROM AppBundle:Seances p WHERE p.classe=:id AND p.jours='Mardi' ORDER BY p.tempsDebut")->setParameter('id',$classe)->getResult();
        $wednesday = $em->createQuery(" SELECT p FROM AppBundle:Seances p WHERE p.classe=:id AND p.jours='Mercredi' ORDER BY p.tempsDebut")->setParameter('id',$classe)->getResult();
        $thursday = $em->createQuery(" SELECT p FROM AppBundle:Seances p WHERE p.classe=:id AND p.jours='Jeudi' ORDER BY p.tempsDebut")->setParameter('id',$classe)->getResult();
        $friday = $em->createQuery(" SELECT p FROM AppBundle:Seances p WHERE p.classe=:id AND p.jours='Vendredi' ORDER BY p.tempsDebut")->setParameter('id',$classe)->getResult();
        $saturday = $em->createQuery(" SELECT p FROM AppBundle:Seances p WHERE p.classe=:id AND p.jours='Samedi' ORDER BY p.tempsDebut")->setParameter('id',$classe)->getResult();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        return $this->render('seances/show2.html.twig', array('monday'=>$monday,'tuesday'=>$tuesday,'wednesday'=>$wednesday,'thursday'=>$thursday
            ,'friday'=>$friday,'saturday'=>$saturday, 'classes'=>$listeClasses,'cursus'=>$listeCursus,'classe'=>$classe,
        ));
    }




}
