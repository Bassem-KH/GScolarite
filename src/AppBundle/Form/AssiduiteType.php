<?php

namespace AppBundle\Form;

use AppBundle\Entity\Classe;
use AppBundle\Entity\Cursus;
use AppBundle\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;

class AssiduiteType extends AbstractType
{
    private $em;

    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder //->add('date');
        ->add('date', DateTimeType::class, [
        'widget' => 'choice',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jours',
                'hour' => 'Heure', 'minute' => 'Minute',
            ]

    ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Assiduite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_assiduite';
    }
    protected function addElements(FormInterface $form, Cursus $cur = null,Classe $cl = null,Module $mod=null) {
        // 4. Add the province element
        $form->add('cursus', EntityType::class, array(
            'required' => true,
            'choice_label'=>'nom',
            'data'=>$cur,
            'placeholder' => 'Sélectionner le cursus...',
            'class' => 'AppBundle:Cursus',

        ));
        //$cur->SetNom("Cycle de formation d'ingénieurs - Troisième année");


        // Neighborhoods empty, unless there is a selected City (Edit View)
        $classes = array();
        $modules=array();

        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($cur) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoClasse = $this->em->getRepository('AppBundle:Classe');

            $classes = $repoClasse->createQueryBuilder("q")
                ->where("q.cursus = :cursusid")
                ->setParameter("cursusid", $cur->getId())
                ->getQuery()
                ->getResult();
            $repoModule = $this->em->getRepository('AppBundle:Module');

            $modules = $repoModule->createQueryBuilder("q")
                ->where("q.cursus = :cursusid")
                ->setParameter("cursusid", $cur->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the Neighborhoods field with the properly data
        $form->add('classe', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut sélectionner le cursus...',
            'class' => 'AppBundle:Classe',
            'choices'=>$classes,
            'data'=>$cl,
            'choice_label'=>'nom',
        ));
        $form->add('module', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut selectionner le cursus...',
            'class' => 'AppBundle:Module',
            'choices'=>$modules,
            'data'=>$mod,
            'choice_label'=>'nom',
        ));
        $etudiants = array();
        $Matieres = array();
        if (($cl)&&($mod)) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoEtudiant = $this->em->getRepository('AppBundle:Etudiant');
            $repoMatiere = $this->em->getRepository('AppBundle:Matiere');

            $etudiants = $repoEtudiant->createQueryBuilder("q")
                ->where("q.classe = :classeid")
                ->setParameter("classeid", $cl->getId())
                ->getQuery()
                ->getResult();
            $Matieres = $repoMatiere->createQueryBuilder("q")
                ->where("q.module = :moduleid")
                ->setParameter("moduleid", $mod->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the Neighborhoods field with the properly data
        $form->add('etudiant', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut sélectionner la classe...',
            'class' => 'AppBundle:Etudiant',
            'choices'=>$etudiants,

            'choice_label'=>'nom',
        ));
        $form->add('matiere', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut sélectionner le module ...',
            'class' => 'AppBundle:Matiere',
            'choices'=>$Matieres,

            'choice_label'=>'nom',
        ));
    }
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected City and convert it into an Entity
        $cur = $this->em->getRepository('AppBundle:Cursus')->find($data['cursus']);
        $cl = $this->em->getRepository('AppBundle:Classe')->find($data['classe']);
        $mod = $this->em->getRepository('AppBundle:Module')->find($data['module']);
        $this->addElements($form, $cur, $cl,$mod);
    }



    function onPreSetData(FormEvent $event) {
        $person = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $cur = $person->getCursus() ? $person->getCursus() : null;

        $this->addElements($form, $cur);
    }

    protected function addElements2(FormInterface $form, Module $mo = null) {
        // 4. Add the province element
        $form->add('module', EntityType::class, array(
            'required' => true,
            'choice_label'=>'nom',
            'data'=>$mo,
            'placeholder' => 'Sélectionner le module...',
            'class' => 'AppBundle:Module',

        ));
        //$cur->SetNom("Cycle de formation d'ingénieurs - Troisième année");


        // Neighborhoods empty, unless there is a selected City (Edit View)
        $matieres = array();

        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($mo) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoMatiere = $this->em->getRepository('AppBundle:Matiere');

            $matieres = $repoMatiere->createQueryBuilder("q")
                ->where("q.module = :moduleid")
                ->setParameter("moduleid", $mo->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the Neighborhoods field with the properly data
        $form->add('matiere', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut sélectionner le module ...',
            'class' => 'AppBundle:Matiere',
            'choices'=>$matieres,
            'choice_label'=>'nom',
        ));
    }
    function onPreSubmit2(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected City and convert it into an Entity
        $mo = $this->em->getRepository('AppBundle:Module')->find($data['module']);

        $this->addElements2($form, $mo);
    }

    function onPreSetData2(FormEvent $event) {
        $person = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $cur = $person->getModule() ? $person->getModule() : null;

        $this->addElements2($form, $cur);
    }

}
