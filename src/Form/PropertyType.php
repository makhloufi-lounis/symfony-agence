<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('address')
            ->add('postalCode')
            ->add('sold');
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
