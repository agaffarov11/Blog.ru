<?php

declare(strict_types=1);

namespace Authorization\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Mezzio\Authentication\UserInterface;
use Laminas\Diactoros\Response\RedirectResponse;

use App\Service\UserService;

class LogoutHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $userService;
    private $confArray;

    public function __construct(TemplateRendererInterface $renderer,UserService $userService,$confArray)
    {
        $this->renderer = $renderer;
        $this->userService = $userService;
        $this->confArray = $confArray;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
         
        
        $session = $request->getAttribute('session');

        $session->unset(UserInterface::class);


        return new RedirectResponse("/");
        
       

      
      
         
        

    }
}
