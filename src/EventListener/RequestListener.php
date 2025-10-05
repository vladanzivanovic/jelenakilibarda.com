<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $this->setLocaleFromPostData($request);

        $requestUri = $request->server->get('REQUEST_URI');

        if (strpos($requestUri, '/public') === 0) {

            $redirectUri = str_replace('/public', '', $requestUri);

            $event->setResponse(new RedirectResponse($redirectUri !== '' ? $redirectUri : '/', 301));

            return;
        }

        $session = $event->getRequest()->getSession();

        if (false === $session->has('user')) {
            $session->set('user', null);
        }
    }

    private function setLocaleFromPostData(Request $request): void
    {
        $postData = $request->request;

        if (true === $postData->has('language')) {
            $request->setLocale($postData->get('language'));
        }
    }
}
