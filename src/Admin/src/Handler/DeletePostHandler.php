<?php

declare(strict_types=1);

namespace Admin\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Service\PostService;

class DeletePostHandler implements RequestHandlerInterface
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
        

        $postId = $request->getAttribute("id");
        $this->postService->deletePost($postId);

        return new RedirectResponse("/admin/posts");


        
    }
}
