<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Mezzio\Authentication\UserInterface;  
use App\Service\UserService;

class AccountHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $userService;

    public function __construct(TemplateRendererInterface $renderer,UserService $userService)
    {
        $this->renderer = $renderer;
        $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        $email = $request->getAttribute(UserInterface::class)->getIdentity();
        
        $user = $this->userService->getUserByEmail($email);
                       

        return new HtmlResponse($this->renderer->render(
            'app::account',
            ['user' => $user[0]] // parameters to pass to template
        ));
    }
}
