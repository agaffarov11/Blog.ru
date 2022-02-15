<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Service\PostService;
use App\Service\CommentService;
use App\Service\UserService;
use Laminas\InputFilter\InputFilterPluginManager;
use App\InputFilter\RegInputFilter;

class PostPageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PostPageHandler
    {

        ///
        
        

        ///
        return new PostPageHandler($container->get(TemplateRendererInterface::class),$container->get(PostService::class),
    $container->get(CommentService::class),$container->get(UserService::class));
    }
}
