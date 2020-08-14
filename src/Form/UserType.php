<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Regulation;
use App\Entity\User;
use App\Repository\RegulationRepository;
use Libs\RecaptchaBundle\Type\RecaptchaSubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{

    /**
     * @var RegulationRepository
     */
    private $regulationRepository;

    /**
     * UserType constructor.
     * @param RegulationRepository $regulationRepository
     */
    public function __construct(RegulationRepository $regulationRepository)
    {
        $this->regulationRepository = $regulationRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userType', ChoiceType::class, [
                'placeholder' => 'Choisissez ici',
                'choices' => $this->getUserTypes(),
                'label' => 'Utilisateur',
            ])
            ->add('civility', ChoiceType::class, [
                'placeholder' => 'Choisissez ici',
                'choices' => $this->getCivility(),
                'expanded' => false,
                'label' => 'Civilité',
            ])
            ->add('firstName', null, [
                'trim' => true,
                'label' => 'Nom',
            ])
            ->add('lastName', null, [
                'trim' => true,
                'label' => 'Prénom',
            ])
            ->add('phone', null, [
                'trim' => true,
                'label' => 'Téléphone',
            ])
            ->add('email', EmailType::class, [
                'trim' => true,
                'label' => 'Email',
                'attr' => [
                    'placeholder' => "me@exemple.co",
                ]
            ])
            ->add('username', null, [
                'label' => 'Identifiant de connexion',
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'trim' => true,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation mot de passe'),
            ))
            ->add('city', EntityType::class, [
                'placeholder' => 'Choisissez ici',
                'label' => 'Ville',
                'class' => City::class,
                'choice_label' => 'cityName',
            ])
            ->add('postalCode', null, [
                'trim' => true,
                'label' => 'Code postal',
            ])
            ->add('address', null, [
                'trim' => true,
                'label' => 'Adresse',
            ])
            ->add('termsAccepted', CheckboxType::class, array(
                'mapped' => false,
                'value' => Regulation::REGULATION_TYPE_CGU,
                'label' => Regulation::REGULATION_TYPE_TEXT,
                'constraints' => new IsTrue([
                    'message' => 'Vous devez accepter les CGV'
                ])
            ))
            /*->add('recaptcha', RecaptchaSubmitType::class, [
                'label' => 'Inscrivez vous',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])*/
            ;
            if($options['block_name'] === 'admin'){
                $builder->add('status', ChoiceType::class, [
                    'placeholder' => 'Choisissez ici',
                    'choices' => $this->getUserStatus(),
                ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function getCivility() {
        $choices = User::CIVILITY;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] =  $k;
        }
        return $output;
    }

    public function getUserTypes() {
        $choices = User::USER_TYPES;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] =  $k;
        }
        return $output;
    }

    public function getUserStatus() {
        $choices = User::USER_STATUS;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] =  $k;
        }
        return $output;
    }

    public function getRegulationTypes() {
        $choices = Regulation::REGULATION_TYPES;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] =  $k;
        }
        return $output;
    }
}
