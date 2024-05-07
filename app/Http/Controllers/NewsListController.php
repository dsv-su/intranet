<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsListController extends Controller
{
    public function list($collection)
    {
        $collections = \Statamic\Statamic::tag('collection:'. $collection)->where('collection', $collection)->fetch();

        return (new \Statamic\View\View)
            ->template('news.list')
            ->layout('mylayout')
            ->with(['type' => 'news', 'collections' => $collections] );
    }
}
