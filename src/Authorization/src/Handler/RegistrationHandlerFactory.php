<?php

declare(strict_types=1);

namespace Authorization\Handler;

use Authorization\InputFilter\RegInputFilter;
use Laminas\InputFilter\InputFilterPluginManager;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Service\UserService;

class RegistrationHandlerFactory  
{
    public function __invoke(ContainerInterface $container) : RegistrationHandler
    {
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter = $pluginManager->get(RegInputFilter::class);
        $userService = $container->get(UserService::class);
        return new RegistrationHandler($container->get(TemplateRendererInterface::class),$inputFilter,$userService);
    }
}
