<?php


namespace App\Models;


abstract class Model
{
    protected static $table = "table";

    // user singleton to connect to the database
    public static function Find($id)
    {
        $table = self::$table;
        $query = "SELECT * FROM $table WHERE id = $id $table LIMIT 1";
        echo $query;
    }
}
