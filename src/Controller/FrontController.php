<?php

namespace App\Controller;

use App\Form\ContactForm;
use App\Form\LoginForm;
use App\Mapper\Article;
use App\Mapper\GuestBook;
use App\Mapper\User;

class FrontController extends Controller
{
    private $article;

    protected function boot()
    {
        $this->article = $this->get(Article::class);
        $this->app->mset(array(
            'popularArticles' => $this->article->findPopulars(),
        ));
    }

    public function home()
    {
        $page = (int) ($this->app->get('GET.page') ?? 1);

        return $this->render('front/home.php', array(
            'latestArticles' => $this->article->findLatests($page),
        ));
    }

    public function article($slug)
    {
        $article = $this->article->findOneBySlug($slug);

        if ($article->dry()) {
            return $this->app->error(404);
        }

        return $this->render('front/article.php', array(
            'article' => $article,
        ));
    }

    public function page($page)
    {
        return $this->article($page);
    }

    public function sitemap()
    {
        return $this->render('front/sitemap.php', array(
            'sitemap' => $this->article->buildSitemap(),
        ));
    }

    public function contact(ContactForm $form, GuestBook $guestBook)
    {
        if ($form->build()->isSubmitted() && $form->valid()) {
            $guestBook->fromArray($form->getData())->save();

            return $this->notify('Your message has been saved.');
        }

        return $this->render('front/contact.php', array(
            'form' => $form,
        ));
    }

    public function login(LoginForm $form)
    {
        $message = null;

        if ($form->build()->isSubmitted() && $form->valid() &&
            $this->auth->attempt($form->username, $form->password, $message)) {

            $target = $this->auth->isGranted('ROLE_ADMIN') ? 'dashboard' : 'home';

            return $this->app->reroute($target);
        }

        return $this->render('front/login.php', array(
            'form' => $form,
            'message' => $message,
        ));
    }

    public function logout()
    {
        $this->auth->logout();

        return $this->app->reroute('home');
    }
}
