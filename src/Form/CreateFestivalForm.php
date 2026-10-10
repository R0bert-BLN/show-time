<?php

namespace App\Form;

use App\Entity\Festival;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateFestivalForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])

            ->add('startDate', DateTimeType::class, [
                'label' => 'Start Date'
            ])

            ->add('endDate', DateTimeType::class, [
                'label' => 'End Date'
            ])

//            ->add('picture')

            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'label' => 'Location',
            ])

            ->add('bands', CollectionType::class, [
                'entry_type' => FestivalBandForm::class,
                'entry_options' => [
                    'label' => false
                ],
                'label' => 'Line-up',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'prototype_name' => '__bands__'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Festival::class,
        ]);
    }
}
