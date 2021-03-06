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

class MatiereType extends AbstractType
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


            ->add('semestre', ChoiceType::class, [
                'choices'  => [
                    'Semestre 1' => "Semestre 1",
                    'Semestre 2' => "Semestre 2",
                ],
            ])
            ->add('nombreAbsences')
            ->add('coefficient');
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Matiere'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_matiere';
    }
    protected function addElements(FormInterface $form, Cursus $cur = null) {
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
        $modules = array();

        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($cur) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoModule = $this->em->getRepository('AppBundle:Module');

            $modules = $repoModule->createQueryBuilder("q")
                ->where("q.cursus = :cursusid")
                ->setParameter("cursusid", $cur->getId())
                ->getQuery()
                ->getResult();
        }

        // Add the Neighborhoods field with the properly data
        $form->add('module', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Il faut sélectionner le cursus...',
            'class' => 'AppBundle:Module',
            'choices'=>$modules,
            'choice_label'=>'nom',
        ));
    }
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Search for selected City and convert it into an Entity
        $cur = $this->em->getRepository('AppBundle:Cursus')->find($data['cursus']);

        $this->addElements($form, $cur);
    }

    function onPreSetData(FormEvent $event) {
        $person = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $cur = $person->getCursus() ? $person->getCursus() : null;

        $this->addElements($form, $cur);
    }

}
