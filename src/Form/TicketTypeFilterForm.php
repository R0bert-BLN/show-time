<?php

namespace App\Form;

use App\Filter\BandFilter;
use App\Filter\FestivalFilter;
use App\Filter\TicketTypeFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketTypeFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                ->add('searchParam', TextType::class, [
                'label' => false,
                'required' => false
            ])

                ->add('minTickets', IntegerType::class, [
                    'label' => 'Min Tickets',
                    'required' => false
                ])

                ->add('maxTickets', IntegerType::class, [
                    'label' => 'Max Tickets',
                    'required' => false
                ])

                ->add('minPrice', IntegerType::class, [
                    'label' => 'Min Price',
                    'required' => false
                ])

                ->add('maxPrice', IntegerType::class, [
                    'label' => 'Max Price',
                    'required' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TicketTypeFilter::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
