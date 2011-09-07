<?php

/*
 * This file is part of the Squire framework.
 *
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 *
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Routing;

/**
 * Router
 *
 * A router takes a compiled route sets as input and, when executed, returns
 * the matched routes and the parameters' values.
 * Returns FALSE if no route matches.
 *
 * A router requires you to assign a name to your routes.
 *
 * You should always use a router in your applications.
 *
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class Router implements \ArrayAccess
{
    /**
     * @var array Attached routes.
     * @access protected
     */
    protected $routes = array();

    /**
     * Attaches a route to the router.
	 * This method provides a fluent interface.
     *
     * @param string                       $name   Route's name.
     * @param Squire\Routing\CompiledRoute &$route Compiled route.
     *
     * @access public
     */
    public function attach($name, CompiledRoute &$route)
    {
        $this->routes[$name] = $route;
		return $this;
    }
	
	/**
	 * Allows to attach a route using array syntax.
	 * 
	 * @param string $key   Array key.
	 * @param mixed  $value Array value.
	 * 
	 * @access public
	 */
	public function offsetSet($key, $value)
	{
		$this->attach($key, $value);
	}
	
    /**
     * Deattaches the given route.
     * This method provides a fluent interface.
	 * 
     * @param string $name Route's name.
     *
     * @access public
     *
     * @throws \InvalidArgumentException If the route hasn't been attached.
     */
    public function deattach($name)
    {
        if (!$this->isAttached($name)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" route has never been attached.',
                $name
            ));
        }

        unset($this->routes[$name]);
		return $this;
    }
	
	/**
	 * Allows to deattach a route using array syntax.
	 * 
	 * @param string $key The key.
	 * 
	 * @access public
	 */
	public function offsetUnset($key)
	{
		$this->deattach($key);
	}
	
    /**
     * Returns the attached routes.
     *
     * @return array
     * @access public
     */
    public function getRoutes()
    {
        return $this->routes;
    }
	
	/**
	 * Returns the given attached route.
	 * 
	 * @param string $name Route's name.
	 * 
	 * @return Squire\Routing\Route
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the route hasn't been attached.
	 */
	public function getRoute($name)
	{
		if (!$this->isAttached($name)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" route has never been attached.',
                $name
            ));
        }

		return $this->routes[$name];
	}
	
	/**
	 * Allows to get a route using array syntax.
	 * 
	 * @param string $key Array key.
	 * 
	 * @return Squire\Routing\CompiledRoute
	 * @access public
	 */
	public function offsetGet($key)
	{
		return $this->getRoute($key);
	}
	
    /**
     * Returns whether the given route has been attached to the router.
     *
     * @param string $name Route's name.
     *
     * @return boolean
     * @access public
     */
    public function isAttached($name)
    {
        return isset($this->routes[$name]);
    }
	
	/**
	 * Allows to check whether a given route has been attached using array
	 * syntax.
	 * 
	 * @param string $key Array key.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function offsetExists($key)
	{
		return $this->isAttached($key);
	}
	
    /**
     * Executes the routing. If a matching route is found, returns an array
     * containing the route's name and the URIs parameters. If no valid route
     * is found, returns FALSE.
     *
     * @param string $uri URI to match.
     *
     * @return array|boolean
     * @access public
     */
    public function execute($uri)
    {
        foreach ($this->getRoutes() as $name => $route) {
            $matching = $route->getMatcher()->match($uri);

            if ($matching) {
                return array(
                    'route'  => $name,
                    'params' => $matching,
                );
            }
        }

        return false;
    }
}
