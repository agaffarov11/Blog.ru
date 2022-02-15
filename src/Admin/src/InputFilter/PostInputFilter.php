<?php

namespace Admin\InputFilter;

use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\FileInput;
use Laminas\InputFilter\Input;
use Laminas\Validator;
use Laminas\Filter;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;

class PostInputFilter extends InputFilter {
   
    public function init() {
        $file = new FileInput('postPic');

        $linkdesc = new Input('linkdescription');
        $shortdesc = new Input('shortdescription');
        $mainText = new Input('main_text'); 

        $linkdesc->getFilterChain()->attach(new Filter\StripTags());
        $shortdesc->getFilterChain()->attach(new Filter\StripTags());
        $mainText->getFilterChain()->attach(new Filter\StripTags());
       
        $file->getValidatorChain()->attach(new Validator\File\UploadFile())->attach(new Validator\File\IsImage());
        

        $this->add($linkdesc);
        $this->add($shortdesc);
        $this->add($mainText);
        $this->add($file);
        

    }

    public function moveUploadedFile($uploadedFile,$imgname) {
        $streamFactory = new StreamFactory();

        $uploadedFileFactory = new UploadedFileFactory();

        $target = "./public/images/" . $imgname . ".jpg";

        $filter = new \Laminas\Filter\File\RenameUpload([
            'target'              => $target,
            'randomize'           => false,
            // @var StreamFactoryInterface $streamFactory
            'stream_factory'      => $streamFactory,
            // @var UploadedFileFactoryInterface $uploadedFileFactory
            'upload_file_factory' => $uploadedFileFactory,
        ]);
      
        
           $filter->filter($uploadedFile);
           
           
    }
}