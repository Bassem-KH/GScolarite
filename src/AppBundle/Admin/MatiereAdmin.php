<?php
/**
 * Created by PhpStorm.
 * User: seif eddine salah
 * Date: 3/15/2019
 * Time: 11:39 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class MatiereAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nom', 'text')

            ->add('semestre', ChoiceType::class, [
                'choices'  => [
                    'Semestre 1' => "Semestre 1",
                    'Semestre 2' => "Semestre 2",
                ],
            ])
            ->add('nombre_absences', 'integer')
            ->add('coefficient', 'integer')

            ->add('module', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Module',
                'property' => 'nom',
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('semestre', null, [], ChoiceType::class, [

                'choices'  => [
                    'Semestre 1' => "Semestre 1",
                    'Semestre 2' => "Semestre 2",
                ],
            ])
            ->add('module', null, [], EntityType::class, [
                'class'    => 'AppBundle\Entity\Module',
                'choice_label' => 'nom',
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nom')
            ->add('semestre')
            ->add('coefficient')
        ->add('module.nom');

    }
}