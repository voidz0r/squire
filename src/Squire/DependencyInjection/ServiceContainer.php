<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\DependencyInjection;

/**
 * Service container
 * 
 * This is a service container: it will hold all your services
 * so that you can get them when you need them.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ServiceContainer implements \ArrayAccess
{
	/**
	 * The services.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $services = array();
	
	/**
	 * Registers a service under the given name.
	 * 
	 * @param string 							 $name
	 * @param Squire\DependencyInjection\Service &$service
	 * 
	 * @access public
	 */
	public function register($name, Service &$service)
	{
		$this->services[$name] = $service;
	}
	
	/**
	 * Provides the same functionalities as `register()`
	 * but using array access.
	 * 
	 * @param string $name
	 * @param mixed  $value
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer::register()
	 */
	public function offsetSet($name, $service)
	{
		$this->register($name, $service);
	}
	
	/**
	 * Returns all the services.
	 * 
	 * @return array
	 * @access public
	 */
	public function all()
	{
		return $this->services;
	}
	
	/**
	 * Returns whether the given service is registered.
	 * 
	 * @param string $name
	 * 
	 * @return boolean
	 * @access public
	 */
	public function has($name)
	{
		return array_key_exists($name, $this->all());
	}
	
	/**
	 * Provides the same functionalities as `has()`
	 * but using array access.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer::has()
	 */
	public function offsetExists($name)
	{
		return $this->has($name);
	}
	
	/**
	 * Returns the service registered under the given name.
	 * 
	 * @param string $name
	 * 
	 * @return Squire\DependencyInjection\Service
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the service is not registered
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer::has()
	 * @uses Squire\DependencyInjection\ServiceContainer::all()
	 */
	public function get($name)
	{
		if (!$this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" service is not registered.',
				$name
			));
		}
		
		$services = $this->all();
		return $services[$name];
	}
	
	/**
	 * Provides the same functionalities as `get()`
	 * but using array access.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer::get()
	 */
	public function offsetGet($name)
	{
		return $this->get($name);
	}
	
	/**
	 * Removes a service from the stack.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the service does not exist
	 */
	public function remove($name)
	{
		if (!$this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" service is not registered.',
				$name
			));
		}
		
		unset($this->services[$name]);
	}
	
	/**
	 * Provides the same functionalities as `remove()`
	 * but using array access.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer::remove()
	 */
	public function offsetUnset($name)
	{
		$this->remove($name);
	}
	
	/**
	 * Clears the stack removing all the services.
	 * 
	 * @access public
	 */
	public function clear()
	{
		$this->services = array();
	}
}
