<?php

namespace Wolfi\CC\Controller;

use Facebook\Facebook;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Wolfi\CC\DB\DbHelper;

class PostController
{
    public function postAction(
        Request $request,
        $fbPostId,
        DbHelper $dbHelper,
        Engine $engine
    ) {
        $post = $dbHelper->getPostByFbPostId($fbPostId);

        if ($request->get('inputComment')) {
            $dbHelper->saveComment($post->getPostId(), $request->get('inputComment'), $request->getClientIp(),
                $request->headers->get('user-agent'));
        }

        $comments = $dbHelper->getCommentsByPostId($post->getPostId());
        $data = [
            'title' => 'Codechallenge - Last Post',
            'post' => $post,
            'comments' => $comments
        ];
        return new Response($engine->render('content/post', $data));
    }

    public function postListAction(
        Request $request,
        Session $session,
        Facebook $facebook,
        DbHelper $dbHelper,
        Engine $engine
    ) {
        $accessToken = $session->get('fb_access_token');
        $user = $facebook->get('me', $accessToken)->getGraphUser();
        $posts = $dbHelper->getPostsByUserId($user->getId());
        $data = [
            'title' => 'Codechallenge - Posts',
            'posts' => $posts,
        ];
        return new Response($engine->render('content/post_list', $data));
    }

    public function publicAction(Request $request, $publicUuid, DbHelper $dbHelper, Engine $engine)
    {
        $post = $dbHelper->getPostByPublicUuid($publicUuid);

        if ($request->get('inputComment')) {
            $dbHelper->saveComment($post->getPostId(), $request->get('inputComment'), $request->getClientIp(),
                $request->headers->get('user-agent'));
        }

        $comments = $dbHelper->getCommentsByPostId($post->getPostId());
        $data = [
            'title' => 'Codechallenge - Last Post',
            'post' => $post,
            'comments' => $comments
        ];
        return new Response($engine->render('content/post', $data));
    }
}