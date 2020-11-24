<?php

namespace LogementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adress')
            ->add('type',ChoiceType::class,[


                'choices'  => [
                    '' => '',
                    'appartement' => 'appartement',
                    'maison'     => 'maison',
                ],
                'attr' => array('class' => 'form-control'),

            ])
            ->add('description')->add('capacite')->add('resident');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LogementBundle\Entity\Logement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'logementbundle_logement';
    }


}
