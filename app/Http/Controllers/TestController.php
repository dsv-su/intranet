<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test()
   {
       $collections = \Statamic\Statamic::tag('collection:news')->where('collection', 'news')->fetch();

       return (new \Statamic\View\View)
           ->template('news.list')
           ->layout('mylayout')
           ->with(['type' => 'news', 'collections' => $collections] );
   }

}
