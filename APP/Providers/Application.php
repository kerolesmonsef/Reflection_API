<?php

namespace App\Providers;

use App\Request;
use Exception;
use ReflectionClass;
use ReflectionException;

class Application
{
    /** @var array */
    protected $bindings = [];

    /**
     * @param string $name
     * @param Closure $closure
     */
    public function instance(string $name, $closure)
    {
        $this->bindings[$name] = $closure;
    }

    /**
     * @param string|array $action
     * @throws Exception
     */
    public function callActionAndGetResponse($action)
    {
        if (is_array($action)) {
            [$controller, $method] = $action;
        } elseif (is_string($action)) {
            [$controller, $method] = explode("@", $action);
        } else {
            throw new Exception("the action must be string or array");
        }

        $object = $this->resolveDependenciesAndGetObject($controller);
        $params = $this->resolveMethodParams($object, $method);

        call_user_func_array([$object, $method], $params);
    }

    public function resolveDependenciesAndGetObject($concrete)
    {
        $reflection = new ReflectionClass($concrete);

        $params = [];
        if (
            $reflection->hasMethod("__construct") and
            $reflection->getMethod("__construct")->getNumberOfParameters() > 0
        ) {
            foreach ($reflection->getMethod("__construct")->getParameters() as $param) {
                if ($this->notResolvable($params)) {
                    throw new Exception("we cant resolve $param");
                }

                $params[] = $this->make($param->getType()->getName());

            }
        }
        return new $concrete(...$params);
    }

    public function notResolvable($class_name): bool
    {
        return false;
    }

    public function make($concrete)
    {
        $callback = $this->bindings[$concrete] ?? null;
        if (is_callable($callback)) {
            return $callback();
        }

        if ($object = $this->resolveDependenciesAndGetObject($concrete)) {
            return $object;
        }


        if (is_string($concrete)) {
            throw new Exception("cant resolve $concrete");
        }
        return new $concrete;
    }

    /**
     * @param $object
     * @param string $method
     * @return array
     * @throws ReflectionException
     */
    public function resolveMethodParams($object, string $method): array
    {
        $requestParams = $this->make(Request::class)->getParams();

        $reflection = new ReflectionClass($object);
        $params = [];
        if (
            $reflection->hasMethod($method) and
            $reflection->getMethod($method)->getNumberOfParameters() > 0
        ) {
            foreach ($reflection->getMethod($method)->getParameters() as $param) {
                if ($param->getType()) {
                    $params[] = $this->make($param->getType()->getName());
                }else{
                    $params[] = array_shift($requestParams);
                }
            }
        }
        return $params;
    }
}
