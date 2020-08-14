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


namespace Libs\RecaptchaBundle;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RecaptchaCompilerPass
 * @package Libs\RecaptchaBundle
 */
class RecaptchaCompilerPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('twig.form.resources')) {
            $param = $container->getParameter('twig.form.resources') ?: [];
            array_unshift($param, '@!Recaptcha/fields.html.twig');
            $container->setParameter('twig.form.resources', $param);
        }
    }
}