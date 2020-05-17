<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

            if($options['block_name'] === 'intuitive_search'){
                $builder->add('maxPrice', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Prix max'
                        ]
                    ])
                    ->add('minArea', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Surface min'
                        ]
                    ])
                    /*->add('submit', SubmitType::class, [
                        'label' => 'Rechercher'
                    ])*/
                    ;
            }else {
                $builder->add('minPrice', IntegerType::class, [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Prix min'
                    ]
                ])
                    ->add('maxPrice', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Prix max'
                        ]
                    ])
                    ->add('minArea', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Surface min'
                        ]
                    ])
                    ->add('maxArea', IntegerType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Surface max'
                        ]
                    ])
                    ->add('$activities', TextType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => "Secteurs d'activités"
                        ]
                    ])
                    ->add('location', TextType::class, [
                        'required' => false,
                        'label' => false,
                        'attr' => [
                            'placeholder' => "Localisations"
                        ]
                    ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
