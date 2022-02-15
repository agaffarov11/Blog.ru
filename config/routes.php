<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
   // $app->get('/[page/{pg:\d+}[/category/{cat}]]', App\Handler\MainPageHandler::class, 'home');
    $app->get('/', App\Handler\MainPageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->route('/post/{id}', [Mezzio\Session\SessionMiddleware::class,App\Handler\PostPageHandler::class],['GET','POST'], 'postPage');
    $app->route('/login', [Mezzio\Session\SessionMiddleware::class,Authorization\Handler\LoginHandler::class],['GET','POST'],'login');
    $app->route('/register', Authorization\Handler\RegistrationHandler::class,['GET','POST'],'registration');
    $app->route('/account', [Mezzio\Session\SessionMiddleware::class,
    Mezzio\Authentication\AuthenticationMiddleware::class,
    App\Handler\AccountHandler::class],['GET'],'account');
    $app->get('/logout',[Mezzio\Session\SessionMiddleware::class,Authorization\Handler\LogoutHandler::class],'logout');
    $app->get('/admin',[Mezzio\Session\SessionMiddleware::class,Mezzio\Authentication\AuthenticationMiddleware::class,
    Mezzio\Authorization\AuthorizationMiddleware::class,Admin\Handler\DashboardHandler::class],'admin');
    $app->get('/admin/posts',[Mezzio\Session\SessionMiddleware::class,Mezzio\Authentication\AuthenticationMiddleware::class,
    Mezzio\Authorization\AuthorizationMiddleware::class,Admin\Handler\PostListHandler::class],'postList');
    $app->any('/admin/addpost',[Mezzio\Session\SessionMiddleware::class,Mezzio\Authentication\AuthenticationMiddleware::class,
    Mezzio\Authorization\AuthorizationMiddleware::class,Admin\Handler\PostUploadHandler::class],'addpost');
    
    $app->any('/admin/posts/delete/{id}',[Mezzio\Session\SessionMiddleware::class,Mezzio\Authentication\AuthenticationMiddleware::class,
    Mezzio\Authorization\AuthorizationMiddleware::class,Admin\Handler\DeletePostHandler::class],'deletePost');

    
    
    
};
