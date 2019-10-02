<?php

namespace AppBundle\Form;

use AppBundle\Entity\Specc;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class InscriptionType extends AbstractType
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
        $builder->add('nom')
            ->add('prenom')
            ->add('cin')
            ->add('email')
            ->add('releve', 'file', array('label' => 'Relevés de notes (PDF file)'));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Inscription'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_inscription';
    }

    protected function addElements(FormInterface $form, Specc $cur = null) {
        // 4. Add the province element
        $form->add('specc', EntityType::class, array(
            'required' => true,
            'choice_label'=>'nom',
            'data'=>$cur,
            'placeholder' => 'Sélectionner la spécialité...',
            'class' => 'AppBundle:Specc',

        ));

        $cycles = array();


        if ($cur) {

            $repoCycle = $this->em->getRepository('AppBundle:Cycle');

            $cycles = $repoCycle->createQueryBuilder("q")
                ->where("q.specc = :speccid")
                ->setParameter("speccid", $cur->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the Neighborhoods field with the properly data
        $form->add('cycle', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut sélectionner la spécialité...',
            'class' => 'AppBundle:Cycle',
            'choices'=>$cycles,
            'choice_label'=>'nom',
        ));
    }
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected City and convert it into an Entity
        $cur = $this->em->getRepository('AppBundle:Specc')->find($data['specc']);

        $this->addElements($form, $cur);
    }

    function onPreSetData(FormEvent $event) {
        $person = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $cur = $person->getSpecc() ? $person->getSpecc() : null;

        $this->addElements($form, $cur);
    }
}
