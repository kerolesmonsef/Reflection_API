<?php


namespace App\Controllers;


class Controller
{
    public function view($viewName = null, $data = [])
    {
        if ($viewName == null) {
            return;
        }
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        require_once(__DIR__ . "/../Views/$viewName.php");
    }
}
