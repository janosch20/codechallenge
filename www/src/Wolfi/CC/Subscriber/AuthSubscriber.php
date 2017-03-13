<?php

namespace Wolfi\CC\Subscriber;

use Facebook\Facebook;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthSubscriber implements EventSubscriberInterface
{
    /** @var  Session */
    private $session;

    /** @var  Facebook */
    private $facebook;

    public function __construct(Session $session, Facebook $facebook)
    {
        $this->session = $session;
        $this->facebook = $facebook;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'onRequest'];
    }

    public function onRequest(GetResponseEvent $event)
    {
        return;
        if ($event->getRequest()->get('_route') === 'signin') {
            return;
        }

        try {
            $user = $this->facebook->get('me', $this->session->get('fb_access_token'))->getGraphUser();
        } catch (\Exception $exception) {
            //TODO better exception handling
            $event->setResponse(new RedirectResponse('/signin'));
        }
    }
}