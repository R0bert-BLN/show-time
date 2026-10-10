<?php

namespace App\Form;

use App\Enum\BookingStatus;
use App\Filter\BandFilter;
use App\Filter\FestivalFilter;
use App\Filter\TicketPaymentFilter;
use App\Filter\TicketTypeFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketPaymentFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                ->add('searchParam', TextType::class, [
                'label' => false,
                'required' => false
            ])

                ->add('status', EnumType::class, [
                    'class' => BookingStatus::class,
                    'label' => 'Status',
                    'required' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TicketPaymentFilter::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
