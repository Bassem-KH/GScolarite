<?php
/**
 * Created by PhpStorm.
 * User: seif eddine salah
 * Date: 3/15/2019
 * Time: 10:51 PM
 */

namespace AppBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ModuleAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nom', 'text')
                    ->add('cursus', 'sonata_type_model', array(
                          'class' => 'AppBundle\Entity\Cursus',
                             'property' => 'nom',
    ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom')
            ->add('cursus', null, [], EntityType::class, [
                'class'    => 'AppBundle\Entity\Cursus',
                'choice_label' => 'nom',
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nom')

            ->add('cursus.nom');
    }
}