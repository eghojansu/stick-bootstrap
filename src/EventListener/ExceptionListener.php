<?php

declare(strict_types=1);

namespace App\EventListener;

use Fal\Stick\Template\TemplateInterface;
use Fal\Stick\Util;
use Fal\Stick\Web\Event\GetResponseForExceptionEvent;
use Fal\Stick\Web\Exception\HttpException;
use Fal\Stick\Web\Response;

class ExceptionListener
{
    public function handle(GetResponseForExceptionEvent $event, TemplateInterface $template)
    {
        $request = $event->getRequest();

        if ($request->isAjax()) {
            return;
        }

        $debug = $event->getKernel()->isDebug();
        $exception = $event->getException();
        $code = $exception instanceof HttpException ? $exception->getStatusCode() : 500;

        $response = new Response(null, $code);
        $status = $response->getStatusText();
        $message = $exception->getMessage() ?: sprintf('%s %s (%s %s)', $request->getMethod(), $request->getPath(), $code, $status);
        $trace = $debug ? Util::trace($exception->getTrace()) : null;
        $content = $template->render('error/error', compact('code', 'status', 'message', 'trace', 'debug'));

        $response->setContent($content);
        $event->setResponse($response);
    }
}
