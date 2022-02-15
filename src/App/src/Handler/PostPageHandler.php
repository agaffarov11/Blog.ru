<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Service\PostService;
use App\Service\CommentService;
use App\Entity\Comment;
use Mezzio\Authentication\UserInterface;
use App\Service\UserService;
use Laminas\Diactoros\Response\RedirectResponse;


class PostPageHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $postService;
    private $commentService;
    private $userService;

    public function __construct(TemplateRendererInterface $renderer,PostService $postService,
    CommentService $commentService,UserService $userService)
    {
        $this->renderer = $renderer;
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        // Render and return a response:
        $session = $request->getAttribute("session");
        

        $path = $request->getUri();
        $post = $this->postService->getPostById($request->getAttribute('id'));
        $comments = $this->commentService->getCommentsOnPost($request->getAttribute('id'));
       
        $authenticated = $session->has(UserInterface::class);


        if($request->getMethod()==='POST') {
           
          return $this->postTheComment($request,$post,$session);
           
           
        }

               

        return new HtmlResponse($this->renderer->render(
            'app::post-page',
            ['post' => $post,'comments' => $comments,'path' => $path,'authenticated' => $authenticated] // parameters to pass to template
        ));
    }

    public function postTheComment(ServerRequestInterface $request,$post,$session) {
        $commentText = $request->getParsedBody()['comment_text'];

       

        $username = $session->get(UserInterface::class)['username'];

        $user = $this->userService->getUserByEmail($username)[0];

        $comment1 = new Comment();
        $comment1->setCommentText($commentText);
        $comment1->setUser($user);
        $comment1->setPost($post);

        $this->commentService->addComment($comment1);

        return new RedirectResponse($request->getUri());
    }
}
