<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use App\Service\CategoryService;
use App\Service\PostService;

class MainPageHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $postService;
    private $catService;

    public function __construct(TemplateRendererInterface $renderer,PostService $postService,CategoryService $catService)
    {
        $this->renderer = $renderer;
        $this->postService = $postService;
        $this->catService = $catService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
      
     
      
      $params = $request->getQueryParams();
      
     
      if(!empty($params['page'])) {
         $page = $params['page'];
      }
      if(!empty($params['cat'])) {
        $category = $params['cat'];
      }

      $postsPerPage = 3;

      $catList = $this->catService->getAllCategories();

      if($page != null) {

        $postList = $this->postService->getPostsWithLimit(($page-1)*$postsPerPage,$postsPerPage,$category);
        
      }else {
        $postList = $this->postService->getPostsWithLimit(0,$postsPerPage,$category);
        $page = 1;
      }
      
     
      $count = sizeof($postList);

      

        return new HtmlResponse($this->renderer->render(
            'app::main-page',
            ['postList' => $postList,'currentPage' => $page,'postNum' => $count,'catList' => $catList,'cat'=>$category] // parameters to pass to template
        ));
        

    }
}
