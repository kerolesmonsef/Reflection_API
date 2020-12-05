<?php

use App\Controllers\HomeController;
use App\Controllers\ProfileController;
use App\Providers\Application;
use App\Request;
use App\Route;

require 'vendor/autoload.php';

require_once('helpers.php');
require_once('autoloader.php');
require_once('route.php');

//dd(Route::$validRouts);

/**
 * you can do this with another way
 * 1- foreach routes as route => action
 * 2- separate the url with "/" and call it route_i_parts (array) and separate the current url current_url_parts ( array)
 * 3- if they are not equal len then continue for another route
 * 4- make another for loop throw the route_i_parts
 * 5- and compare the {.*?} with the parts and compare the other parts with the other parts
 * 'profile/{name}' => www.domain.com/profile/keroles
 * in the above example compare profile with profile and compare {name} with keroles
 *
 *
 * @param string $url
 * @return array
 * @throws Exception
 */
function routeGetMatch(string $url)
{
    $url = explode("?", $url)[0];
    $routes = Route::$validRouts;


    foreach ($routes as $route) {
        $action = $route['action'];
        $method = $route['method'];
        $route = $route['route'];
        preg_match_all("#\{(.*?)\}#", $route, $matches);
        if (!empty($matches[0])) {
            // prepare the route with regular expression
            $route = str_replace($matches[0], '(\w+)', $route);
            $route = str_replace('/', '\\/', $route);
        }

        preg_match_all("#^" . $route . "$#", $url, $matches);
        if (isset($matches[0][0])) {
            array_shift($matches);
            if (strtolower($method) != strtolower($_SERVER['REQUEST_METHOD'])){
                $requested_method = $_SERVER['REQUEST_METHOD'];
                throw new Exception("The $requested_method is Not Supported For This Route, Supported $method");
            }
            return [$action, sizeof($matches) > 0 ? array_merge(...$matches) : []];
        }
    }

    throw new Exception("Route [ $url ] Not Found.");
}

//$routes = [
//    '/' => [HomeController::class, 'index'],
//    '/profile/{name}' => [ProfileController::class, "profile"],
//    '/profile/{name}/friends' => [ProfileController::class, "show"],
//    '/profile/{name}/friends/{limit}' => [ProfileController::class, "show"],
//];

/**
 * if you enter www.domain.com/profile/keroles
 * then $action = ProfileController@show
 * $queryParameters = ['keroles']
 *
 *
 *
 */


[$action, $queryParameters] = routeGetMatch($_SERVER['REQUEST_URI'] ?? "/");

//dd($queryParameters);

$app = new Application();

$app->instance(Request::class, function () use ($queryParameters) {
    return new Request($queryParameters, $_POST);
});


$app->callActionAndGetResponse($action);
