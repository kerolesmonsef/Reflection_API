<?php


namespace App\Models;


class User extends Model
{
    // user singleton to connect to the database
    protected static $table = "users";
}
