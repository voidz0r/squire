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
 * Service holder
 * 
 * An instance of this class holds a service. It is possible
 * to specify service parameters using array access.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class Service implements \ArrayAccess
{
	/**
	 * Whether the service is shared.
	 * 
	 * @var    boolean
	 * @access protected
	 */
	protected $shared = false;
	
	/**
	 * The callback that returns the service.
	 * 
	 * @var    callback
	 * @access protected
	 */
	protected $callback = null;
	
	/**
	 * The service parameters.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $params = array();
	
	/**
	 * Creates the service basing on the provided data.
	 * 
	 * @param callback $callback Callback that returns the service
	 * @param boolean  $shared   Whether the service is shared
	 * 
	 * @return Squire\DependencyInjection\Service
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the callback is invalid
	 */
	public function __construct($callback, $shared = false)
	{
		$this->callback = $callback;
		$this->shared   = (bool)$shared;
		
		if (!is_callable($callback, false, $readable_callback)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is an invalid callback.',
				$callback
			));
		}
		
		if (is_array($callback)) {
			$reflection = new \ReflectionMethod($callback[0], $callback[1]);
		}
		else {
			$reflection = new \ReflectionFunction($callback);
		}
		
		$params = $reflection->getParameters();
		$paramc = count($params);
		
		if ($paramc != 1) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" should accept 1 parameter.',
				$readable_callback
			));
		}
		
		if (!$params[0]->isArray()) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" should accept an array as parameter.',
				$readable_callback
			));
		}
	}
	
	/**
	 * Returns whether the service is shared.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isShared()
	{
		return $this->shared;
	}
	
	/**
	 * Returns the callback returning the service.
	 * 
	 * @return callback
	 * @access public
	 */
	public function getCallback()
	{
		return $this->callback;
	}
	
	/**
	 * Sets a parameter.
	 * 
	 * @param string $name
	 * @param mixed  $value
	 * 
	 * @access public
	 */
	public function setParam($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	 * Provides the same functionalities as `setParam()`
	 * but using array access.
	 * 
	 * @param string $name
	 * @param mixed  $value
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service::setParam()
	 */
	public function offsetSet($name, $value)
	{
		$this->setParam($name, $value);
	}
	
	/**
	 * Returns the parameters.
	 * 
	 * @return array
	 * @access public
	 */
	public function getParams()
	{
		return $this->params;
	}
	
	/**
	 * Returns a parameter's value.
	 * 
	 * @param string $name
	 * 
	 * @return mixed
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the parameter doesn't exist
	 * 
	 * @uses Squire\DependencyInjection\Service::hasParam()
	 * @uses Squire\DependencyInjection\Service::getParams()
	 */
	public function getParam($name)
	{
		if (!$this->hasParam($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" parameter has not been set.',
				$name
			));
		}
		
		$params = $this->getParams();
		return $params[$name];
	}
	
	/**
	 * Provides the same functionalities as `getParam()`
	 * but using array access.
	 * 
	 * @param string $name
	 * 
	 * @return mixed
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service::getParam()
	 */
	public function offsetGet($name)
	{
		return $this->getParam($name);
	}
	
	/**
	 * Returns whether the given parameter has been set.
	 * 
	 * @param string $name
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service::getParams()
	 */
	public function hasParam($name)
	{
		return array_key_exists($name, $this->getParams());
	}
	
	/**
	 * Provides the same functionalities as `hasParam()`
	 * but using array access.
	 * 
	 * @param string $name
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service::hasParam()
	 */
	public function offsetExists($name)
	{
		return $this->hasParam($name);
	}
	
	/**
	 * Removes a parameter from the stack.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the parameter doesn't exist
	 * 
	 * @uses Squire\DependencyInjection\Service::hasParam()
	 */
	public function removeParam($name)
	{
		if (!$this->hasParam($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" parameter has not been set.',
				$name
			));
		}
		
		unset($this->params[$name]);
	}
	
	/**
	 * Provides the same functionalities as `removeParam()`
	 * but using array access.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service::removeParam()
	 */
	public function offsetUnset($name)
	{
		$this->removeParam($name);
	}
	
	/**
	 * Returns an instance of the service. If the service is
	 * shared a new instance will be created only one time and
	 * will be returned by all further calls.
	 * 
	 * @return mixed
	 * @access public
	 */
	public function getInstance()
	{
		static $instance;
		
		if ($this->isShared() && !is_null($instance)) {
			return $instance;
		}
		
		$instance = call_user_func($this->getCallback(), $this->getParams());
		return $instance;
	}
}
