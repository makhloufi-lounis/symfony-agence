<?php
/**
 * Teeps API Server
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/symfony-agence.git for the canonical source repository
 * @copyright Copyright (c) 2020 Agence.
 */

declare(strict_types=1);


namespace Libs\RecaptchaBundle\Type;


use Libs\RecaptchaBundle\Constraints\Recaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RecaptchaSubmitType
 * @package Libs\RecaptchaBundle\Type
 */
class RecaptchaSubmitType extends AbstractType
{

    /**
     * @var string
     */
    private $key;

    /**
     * RecaptchaSubmitType constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'mapped' => false,
           'constraints' => new Recaptcha()
       ]);
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['label'] = false;
        $view->vars['key'] = $this->key;
        $view->vars['button'] = $options['label'];
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'recaptcha_submit';
    }

    /**
     * @return string|null
     */
    public function getParent()
    {
        return TextType::class;
    }
}