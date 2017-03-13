<?php

namespace Wolfi\CC\Controller;

use League\Plates\Engine;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
    public function exceptionAction(FlattenException $exception)
    {
        //TODO not nice
        $template = new Engine(__DIR__ . '/../../../../template');

        //HINT in case an exception is thrown while rendering - should not happen
        ob_clean();

        switch ($exception->getClass()) {
            case 'Facebook\Exceptions\FacebookSDKException':
            case 'Facebook\Exceptions\FacebookAuthenticationException':
                return new RedirectResponse('/signin');
        }

        return new Response($template->render('content/error', ['title' => 'Codechallenge - ERROR']));

        //TODO better Error handling :-( - maybe make my own listener
    }
}