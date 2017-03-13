<?php

namespace Wolfi\CC\Controller;

use Facebook\Facebook;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class SigninController
{
    public function indexAction(Request $request, Facebook $facebook, Engine $engine)
    {
        $helper = $facebook->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl('http://127.0.0.1:8080/signin/callback', ['user_posts']);
        $data = [
            'title' => 'Codechallenge - Signin',
            'loginUrl' => $loginUrl
        ];
        return new Response($engine->render('content/signin', $data));
    }

    public function callbackAction(Request $request, Session $session, Facebook $facebook)
    {
        $fbToken = $facebook->getRedirectLoginHelper()->getAccessToken();
        $session->set('fb_access_token', $fbToken->getValue());

        return new RedirectResponse('/');
    }
}