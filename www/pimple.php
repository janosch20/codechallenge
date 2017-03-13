<?php

$pimple = new \Pimple\Container();

$pimple['db'] = function ($pimple) {
    $dsn = "mysql:host=localhost;dbname=facebook;charset=utf8";
    $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    return new PDO($dsn, 'root', 'root', $opt);
};

/**
 * @param \Pimple\Container $pimple
 * @return \Symfony\Component\Routing\RouteCollection
 */
$pimple['routes'] = function ($pimple) {
    $routes = new \Symfony\Component\Routing\RouteCollection();

    $routes->add(
        'main',
        new \Symfony\Component\Routing\Route(
            '/',
            [
                '_controller' => 'Wolfi\\CC\\Controller\\MainController::indexAction',
                'session' => $pimple['session'],
                'facebook' => $pimple['facebook'],
                'dbHelper' => $pimple['dbHelper'],
                'engine' => $pimple['template'],
            ]
        )
    );

    $routes->add(
        'signin',
        new \Symfony\Component\Routing\Route(
            '/signin',
            [
                '_controller' => 'Wolfi\\CC\\Controller\\SigninController::indexAction',
                'facebook' => $pimple['facebook'],
                'engine' => $pimple['template']
            ]
        )
    );

    $routes->add(
        'signin/callback',
        new \Symfony\Component\Routing\Route(
            '/signin/callback',
            [
                '_controller' => 'Wolfi\\CC\\Controller\\SigninController::callbackAction',
                'session' => $pimple['session'],
                'facebook' => $pimple['facebook']
            ]
        )
    );

    $routes->add(
        'post',
        new \Symfony\Component\Routing\Route(
            '/post',
            [
                '_controller' => 'Wolfi\\CC\\Controller\\PostController::postListAction',
                'session' => $pimple['session'],
                'facebook' => $pimple['facebook'],
                'dbHelper' => $pimple['dbHelper'],
                'engine' => $pimple['template'],
            ]
        )
    );

    $routes->add(
        'post/{postId}',
        new \Symfony\Component\Routing\Route(
            '/post/{fbPostId}',
            [
                '_controller' => 'Wolfi\\CC\\Controller\\PostController::postAction',
                'dbHelper' => $pimple['dbHelper'],
                'engine' => $pimple['template'],
            ]
        )
    );

    $routes->add(
        'public/{publicUuid}',
        new \Symfony\Component\Routing\Route(
            '/public/{publicUuid}',
            [
                '_controller' => 'Wolfi\\CC\\Controller\\PostController::publicAction',
                'dbHelper' => $pimple['dbHelper'],
                'engine' => $pimple['template'],
            ]
        )
    );

    return $routes;
};

/**
 * @param \Pimple\Container $pimple
 * @return \Symfony\Component\HttpFoundation\Session\Session
 */
$pimple['session'] = function ($pimple) {
    $session = new \Symfony\Component\HttpFoundation\Session\Session();
    $session->start();
    return $session;
};

/**
 * @param \Pimple\Container $pimple
 * @return \Wolfi\CC\Subscriber\AuthSubscriber
 */
$pimple['authSubscriber'] = function ($pimple) {
    return new \Wolfi\CC\Subscriber\AuthSubscriber($pimple['session'], $pimple['facebook']);
};

/**
 * @param \Pimple\Container $pimple
 * @return \League\Plates\Engine
 */
$pimple['template'] = function ($pimple) {
    $engine = new \League\Plates\Engine(__DIR__ . '/template');
    return $engine;
};

/**
 * @param \Pimple\Container $pimple
 * @return \Facebook\Facebook
 */
$pimple['facebook'] = function ($pimple) {
    $appId = '1231181667003199';
    $appSecret = '6201345af424eb2c02fa3931e631cdda';
    $config = [
        'app_id' => $appId,
        'app_secret' => $appSecret,
    ];
    return new \Facebook\Facebook($config);
};


$pimple['dbHelper'] = function ($pimple) {
    return new \Wolfi\CC\DB\DbHelper($pimple['db']);
};