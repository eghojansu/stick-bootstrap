<?php

namespace App\Mapper;

use Fal\Stick\Library\Sql\Mapper;

class Article extends Mapper
{
    const CAT_POST = 'post';
    const CAT_PAGE = 'page';

    public function findPopulars()
    {
        return $this->find(null, array(
            'limit' => 10,
            'order' => 'viewer DESC',
        ));
    }

    public function findLatests($page = 1)
    {
        return $this->paginate($page, array(
            'publish' => 1,
            'category' => self::CAT_POST,
        ), array(
            'order' => 'created_at DESC',
        ));
    }

    public function findPages($page = 1, $keyword = null)
    {
        $filter = array('category' => self::CAT_PAGE);

        if ($keyword) {
            $filter['title ~'] = '%'.$keyword.'%';
        }

        return $this->paginate($page, $filter, array(
            'order' => 'created_at DESC',
        ));
    }
}
