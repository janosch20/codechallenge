<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/pimple.php';

//TODO move to pimple
$requestStack = new \Symfony\Component\HttpFoundation\RequestStack();
$routes = $pimple['routes'];
$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($routes, new \Symfony\Component\Routing\RequestContext());
$controllerResolver = new \Symfony\Component\HttpKernel\Controller\ControllerResolver();
$argumentResolver = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver();

$exceptionListener = new \Symfony\Component\HttpKernel\EventListener\ExceptionListener(
    '\\Wolfi\\CC\\Controller\\ErrorController::exceptionAction'
);

$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
$dispatcher->addSubscriber(new \Symfony\Component\HttpKernel\EventListener\RouterListener($matcher, $requestStack));
$dispatcher->addSubscriber(new \Symfony\Component\HttpKernel\EventListener\ResponseListener('UTF-8'));
$dispatcher->addSubscriber($exceptionListener);

$framework = new \Wolfi\CC\Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);

$response = $framework->handle(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
$response->send();