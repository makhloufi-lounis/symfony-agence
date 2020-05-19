<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => '10'],
            ])
            ->add('area')
            ->add('rooms', NumberType::class, [
                'required' => false
            ])
            ->add('bedrooms', NumberType::class, [
                'required' => false
            ])
            ->add('floor', NumberType::class, [
                'required' => false
            ])
            ->add('price', NumberType::class, [
                'required' => false
            ])
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('address')
            ->add('postalCode')
            ->add('sold')
            ->add('imageFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Télécharger une image"
                ]
            ]);
            if($options['block_name'] === 'admin'){
                $builder->add('status', ChoiceType::class, [
                'choices' => $this->getStatus()
                ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] =  $k;
        }
        return $output;
    }
    private function getStatus()
    {
        $choices = Property::STATUS;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] =  $k;
        }
        return $output;
    }
}
