<?php

declare(strict_types=1);

namespace Admin\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\InputFilter\InputFilterInterface;
use App\Service\PostService;
use App\Service\CategoryService;
use Laminas\Filter\File\RenameUpload;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\UploadedFileFactory;


class PostUploadHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $inputFilter;
    private $categoryService;
    private $postService;

    public function __construct(TemplateRendererInterface $renderer,InputFilterInterface $inputFilter,
    CategoryService $categoryService,PostService $postService)
    {
        $this->renderer = $renderer;
        $this->inputFilter = $inputFilter;
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $cats = $this->categoryService->getAllCategories();
        $path = $request->getUri();

        if($request->getMethod()=='POST') {
            
             
           $postData = array_merge_recursive($request->getParsedBody(),$request->getUploadedFiles());
                      
           $this->inputFilter->setData($postData);

           if($this->inputFilter->isValid()) {
              
               $category = $this->categoryService->getCategoryById($postData['cat']);
               $id=$this->postService->addPost($postData['linkdescription'],date_create(),$postData['shortdescription'],
               $postData['main_text'],$category);
               $this->inputFilter->moveUploadedFile($postData['postPic'],$id);

               return new RedirectResponse("/");
               
           }

           
        }        


        return new HtmlResponse($this->renderer->render(
            'admin::post-upload',
            ['cats'=>$cats,'path' => $path] // parameters to pass to template
        ));
    }
}
