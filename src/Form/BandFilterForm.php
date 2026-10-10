<?php

namespace App\Form;

use App\Enum\MusicGenre;
use App\Filter\BandFilter;
use App\Filter\FestivalFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                ->add('searchParam', TextType::class, [
                'label' => false,
                'required' => false
                ])

                ->add('genres', ChoiceType::class, [
                    'label' => 'Genre',
                    'required' => false,
                    'choices' => MusicGenre::getAllGenres(),
                    'multiple' => true,
                    'expanded' => true,
                    'choice_label' => fn (MusicGenre $genre) => $genre->value,
                    'choice_value' => fn (MusicGenre $genre) => $genre->value,
                    'attr' => [
                        'class' => 'grid grid-cols-2'
                    ],

                    'choice_attr' => function($choice, $key, $value) {
                        return [
                            'class' => 'h-4 w-4 rounded border-gray-400 bg-gray-700 text-[#ca8f53] focus:ring-[#c3905f]'
                        ];
                    },
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BandFilter::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
