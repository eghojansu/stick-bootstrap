<?php

namespace App\Controller;

use Fal\Stick\App;
use Fal\Stick\Template;

class Controller
{
    /** @var App */
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    protected function _render(string $file, array $data = null, string $type = 'html'): string
    {
        $this->app['RES.HEADERS.Content-Type'] = 'text/html';

        return $this->app->service(Template::class)->render($file, $data);
    }

    protected function _front(string $file, array $data = null): string
    {
        $template = $this->app->service(Template::class);

        $this->app['RES.HEADERS.Content-Type'] = 'text/html';

        return $template->render('front', [
            'content' => $template->render($file, $data),
        ]);
    }

    protected function _dashboard(string $file, array $data = null): string
    {
        $template = $this->app->service(Template::class);

        $this->app['RES.HEADERS.Content-Type'] = 'text/html';

        return $template->render('dashboard', [
            'content' => $template->render($file, $data),
        ]);
    }
}
