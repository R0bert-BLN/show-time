<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Festival;
use App\Entity\TicketPayment;
use App\Entity\TicketType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketTypeForm extends AbstractType
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

            ->add('totalTickets', IntegerType::class, [
                'label' => 'Total Tickets'
            ])

            ->add('startSaleDate', DateTimeType::class, [
                'label' => 'Start Sale Date'
            ])

            ->add('endSaleDate', DateTimeType::class, [
                'label' => 'End Sale Date'
            ])

            ->add('price', MoneyType::class, [
                'label' => 'Price'
            ])

            ->add('currency', TextType::class, [
                'label' => 'Currency'
            ])

            ->add('festival', EntityType::class, [
                'class' => Festival::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TicketType::class,
        ]);
    }
}
