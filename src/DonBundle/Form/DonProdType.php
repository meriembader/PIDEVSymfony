<?php

namespace DonBundle\Form;

use DonBundle\DonBundle;
use DonBundle\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class DonProdType extends AbstractType
{
    /**
     * {@inheritdoc}
     */



    public function buildForm(FormBuilderInterface $builder, array $options)
    {  $builder->add('idProd',EntityType::class, array(
          'class'=>'DonBundle:Produit',
            'choice_label'=>'libelleProd',
//            'choice_value'=>'idProd'

        ));
        $builder->add('qt')->add('date')->add('heure');
        $builder->add('lieu',ChoiceType::class, [
            'choices' => [
                'Tunis' => 'Tunis',
                'Ariana' => 'Ariana',
            ],
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DonBundle\Entity\DonProd'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'donbundle_donprod';
    }


}
