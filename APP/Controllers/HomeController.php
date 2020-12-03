<?php


namespace App\Controllers;


use App\Request;

class HomeController
{
    public $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request)
    {
        echo "hello World";
        dd($request);
    }
}
