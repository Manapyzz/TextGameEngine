<?php

Class Router {
    private $routes = [];
    private $callback = [];

    public function add($path, $callback) {
        $this->routes[] = $path;
        $this->callback[] = $callback;
    }

    public function getRoute($path) {
        // Check if the path match something
        foreach ($this->routes as $key => $route) {
            if($route == $path) {
                return call_user_func($this->callback[$key]);
            }
        }

        // If the path has no match
        return $this->getRoute('/');
    }
}