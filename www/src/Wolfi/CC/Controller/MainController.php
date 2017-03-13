<?php

namespace Wolfi\CC\Controller;

use Facebook\Facebook;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Wolfi\CC\DB\DbHelper;

class MainController
{
    public function indexAction(Request $request, Session $session, Facebook $facebook, DbHelper $dbHelper, Engine $engine)
    {
        $accessToken = $session->get('fb_access_token');
        $user = $facebook->get('me', $accessToken)->getGraphUser();
        $post = $facebook->get($user->getId(). '/posts', $session->get('fb_access_token'))->getDecodedBody()['data'][0];

        if (!$dbHelper->postExists($post['id'])) {
            //save post locally
            $dateTime = new \DateTime($post['created_time']);
            $dbHelper->savePost($user->getId(), $post['id'], $post['message'], $dateTime->format('Y-m-d H:i:s'));
        }

        return new RedirectResponse("post/{$post['id']}");
    }
}