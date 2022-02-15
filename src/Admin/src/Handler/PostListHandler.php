<?php

declare(strict_types=1);

namespace Admin\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Service\PostService;

class PostListHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $postService;

    public function __construct(TemplateRendererInterface $renderer,PostService $postService)
    {
        $this->renderer = $renderer;
        $this->postService = $postService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
       $posts = $this->postService->getAllPosts();
        
       /** 
       var_dump($posts[0]);
       exit;
       */
       
        return new HtmlResponse($this->renderer->render(
            'admin::post-list',
            ['posts' => $posts] // parameters to pass to template
        ));
    }
}
