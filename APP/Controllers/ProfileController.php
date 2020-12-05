<?php


namespace App\Controllers;


use App\Request;

class ProfileController extends Controller
{
    public function profile(Request $request, $name)
    {
        dd("Hi $name");
    }
}
