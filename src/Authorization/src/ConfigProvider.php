<?php

declare(strict_types=1);

namespace Authorization;

/**
 * The configuration provider for the Authorization module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */

use Laminas\ServiceManager\Factory\InvokableFactory;
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'input_filters' => $this->getInputFilters(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
               
                
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'authorization'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    public function getInputFilters() : array
    {
        return [
            'factories' => [
                InputFilter\RegInputFilter::class => InvokableFactory::class,
            ],
        ];
    }

    
}
