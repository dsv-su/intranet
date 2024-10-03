<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
   public function test()
   {
       return (new \Statamic\View\View)
           ->template('home.partials.search.staff')
           ->layout('mylayout');
   }

   public function pp()
   {
       return (new \Statamic\View\View)
           ->template('pp.index')
           ->layout('mylayout');
   }

}
