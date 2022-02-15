<?php

declare(strict_types=1);

namespace Authorization\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\InputFilter\InputFilterInterface;
use App\Service\UserService;

class RegistrationHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $inputFilter;
    private $userService;

    public function __construct(TemplateRendererInterface $renderer,InputFilterInterface $inputFilter,UserService $userService)
    {
        $this->renderer = $renderer;
        $this->inputFilter = $inputFilter;
        $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        if($request->getMethod()=='POST') {
          $rawData = $request->getParsedBody();
          $this->inputFilter->setData($rawData);

          $emailNotFound = $this->userService->checkEmail($rawData['login']);

          if(!$this->inputFilter->isValid() || !$emailNotFound ) {

            
            $errors = $this->inputFilter->getInvalidInput();

           
            
            return new HtmlResponse($this->renderer->render(
                'authorization::registration',
                ['errors' => $errors,'emailErr' => $emailNotFound] // parameters to pass to template
            ));

          }else {

              $userData = $this->inputFilter->getValues();
              $this->userService->addUser($userData);
              return new RedirectResponse("/");
          }


        }
        return new HtmlResponse($this->renderer->render(
            'authorization::registration',
            [] // parameters to pass to template
        ));
    }
}
