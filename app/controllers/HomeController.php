<?php
class HomeController extends BaseController
{
    public function index()
    {
        if (Auth::check ()) {
            echo Auth::user()->username . '  ';
        }
        return 'hello, everybody!';
    }
}