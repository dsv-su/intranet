<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class NewsListController extends Controller
{
    public function __construct()
    {
        $this->middleware(['checklang', 'locale']);
    }

    public function list($collection)
    {
        $collections = \Statamic\Statamic::tag('collection:'. $collection)->where('collection', $collection)->fetch();

        return (new \Statamic\View\View)
            ->template('news.list')
            ->layout('mylayout')
            ->with(['type' => 'news', 'collections' => $collections] );
    }

    public function swelist($collection)
    {
        App::setLocale('sv');
        $collections = \Statamic\Statamic::tag('collection:'. $collection)->where('collection', $collection)->fetch();

        return (new \Statamic\View\View)
            ->template('news.list')
            ->layout('mylayout')
            ->with(['type' => 'news', 'collections' => $collections] );
    }
}
