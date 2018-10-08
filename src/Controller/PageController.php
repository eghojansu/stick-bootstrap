<?php

namespace App\Controller;

use App\Form\ArticleForm;
use App\Mapper\Article;
use Fal\Stick\Library\Web;

class PageController extends Controller
{
    public function home(Article $article)
    {
        $page = $this->app->get('QUERY.page') ?? 1;

        return $this->render('dashboard/article/list.php', array(
            'data' => $article->findPages($page, $this->app->get('GET.keyword')),
        ));
    }

    public function create(Article $article, ArticleForm $form, Web $web)
    {
        if ($form->build()->isSubmitted() && $form->valid()) {
            $info = array(
                'category' => Article::CAT_PAGE,
                'author' => $this->user->id,
                'slug' => $web->slug($form->title),
                'created_at' => date('y-m-d H:i:s'),
            );
            $article->fromArray($info + $form->getData())->save();

            return $this->notify('Data has been saved.', 'mpage');
        }

        return $this->render('dashboard/article/form.php', array(
            'form' => $form,
        ));
    }

    public function update(Article $article, ArticleForm $form, Web $web)
    {
        $form->build(null, $article->toArray());

        if ($form->isSubmitted() && $form->valid()) {
            $info = array(
                'updated_at' => date('y-m-d H:i:s'),
            );
            $article->fromArray($info + $form->getData())->save();

            return $this->notify('Data has been saved.', 'mpage', 'info');
        }

        return $this->render('dashboard/article/form.php', array(
            'form' => $form,
        ));
    }

    public function delete(Article $article)
    {
        $article->delete();

        return $this->notify('Data has been deleted.', 'mpage', 'warning');
    }
}
