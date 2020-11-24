<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class,[
            'label' =>  'Titre',
            'attr'  => [
                'class' => 'form-control',
            ]
        ])
            ->add('startDate', DateType::class,[
                'label'  =>  'Date de début',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   =>  array(
                    'class' =>  'form-control'
                )])
            ->add('endDate', DateType::class,[
                'label'  =>  'Date de fin',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   =>  array(
                    'class' =>  'form-control'
                )
            ])
            ->add('nbPlace',NumberType::class,[
                'label' =>  'Nombre de places',
                'attr'  => [
                    'class' => 'form-control',
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' =>  'Description',
                'attr'  => [
                    'class' => 'form-control',
                ]
            ])
            ->add('location',TextType::class,[
                'label' =>  'Lieu',
                'attr'  => [
                    'class' => 'form-control',
                ]
            ])
            ->add('picture', FileType::class,array(
                'label'=>'Choisie un fichier',
                'data_class' => null,
                'attr'  => [
                    'class' => 'form-control',]
                ))
            ->add('submit',SubmitType::class,[
                'label' =>  'Ajouter',
                    'attr'  => [
                        'class' => 'btn btn-lg btn-thm',]

            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_event';
    }


}
