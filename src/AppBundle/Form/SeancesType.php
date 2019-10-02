<?php

namespace AppBundle\Form;

use AppBundle\Entity\Cursus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use AppBundle\Entity\Module;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class SeancesType extends AbstractType
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
        $builder->add('salle',EntityType::class,array(
            'class'=>'AppBundle\Entity\Salle',
            'placeholder' => 'Selectionner salle...',
            'choice_label'=>'NumSalle',
            'choice_value'=>'NumSalle',
            'expanded'=>false,

        ))


            ->add('jours', ChoiceType::class, [
                'placeholder' => 'Selectionner le jour...',
                'choices'  => [
                    'Lundi' => "Lundi",
                    'Mardi' => "Mardi",
                    'Mercredi' => "Mercredi",
                    'Jeudi' => "Jeudi",
                    'Vendredi' => "Vendredi",
                    'Samedi' => "Samedi",


                ],
            ])
           ->add('enseignant',EntityType::class,array(
                  'class'=>'AppBundle\Entity\Enseignant',
                  'placeholder' => 'Selectionner un enseignant...',
                  'choice_label'=>'nom',
                  'choice_value'=>'nom',
                  'expanded'=>false,

              ))

           ->add('tempsDebut', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
               'placeholder' => [
                   'hour' => 'Heure', 'minute' => 'Minute',
               ]

            ])
            ->add('tempsFin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'placeholder' => [
                    'hour' => 'Heure', 'minute' => 'Minute',
                ]

            ])
          ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Seances'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_seances';
    }
    protected function addElements(FormInterface $form, Cursus $cur = null,Module $mod=null) {
        // 4. Add the province element
        $form->add('cursus', EntityType::class, array(
            'required' => true,
            'choice_label'=>'nom',
            'data'=>$cur,
            'placeholder' => 'Selectionner le cursus...',
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
            'placeholder' => 'Il faut selectionner le cursus ...',
            'class' => 'AppBundle:Classe',
            'choices'=>$classes,
            'choice_label'=>'nom',
        ));
        $form->add('module', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut selectionner le cursus...',
            'class' => 'AppBundle:Module',
            'choices'=>$modules,
            'data'=>$mod,
            'choice_label'=>'nom', ));

        $Matieres = array();
        if ($mod) {
            // Fetch Neighborhoods of the City if there's a selected city

            $repoMatiere = $this->em->getRepository('AppBundle:Matiere');


            $Matieres = $repoMatiere->createQueryBuilder("q")
                ->where("q.module = :moduleid")
                ->setParameter("moduleid", $mod->getId())
                ->getQuery()
                ->getResult();
        }
        $form->add('matiere', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut selectionner le module ...',
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
        $mod = $this->em->getRepository('AppBundle:Module')->find($data['module']);
        $this->addElements($form, $cur,$mod);
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
            'placeholder' => 'Selectionner le module...',
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
            'placeholder' => 'Il faut selectionner le module ...',
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
