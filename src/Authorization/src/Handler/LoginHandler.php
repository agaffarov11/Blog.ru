<?php

declare(strict_types=1);

namespace Authorization\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Authentication\Session\PhpSession;
use Mezzio\Session\SessionInterface;
use Mezzio\Authentication\UserInterface;     

class LoginHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    private $adapter;

    public function __construct(TemplateRendererInterface $renderer,PhpSession $adapter)
    {
        $this->renderer = $renderer;
        $this->adapter = $adapter;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $session = $request->getAttribute('session');

        if('POST' === $request->getMethod()) {
            return $this->handleLoginAttempt($request,$session);
        }

        return new HtmlResponse($this->renderer->render(
            'authorization::login',
            [] // parameters to pass to template
        ));
    }
    private function handleLoginAttempt(ServerRequestInterface $request,SessionInterface $session) {
        $session->unset(UserInterface::class);

      

        if($this->adapter->authenticate($request)) {
            return new RedirectResponse("/");
        
        }
        //in case of failed login
        return new HtmlResponse($this->renderer->render(
            'authorization::login',
            ['error' => 'invalid credentials'] // parameters to pass to template
        ));


    }
}
