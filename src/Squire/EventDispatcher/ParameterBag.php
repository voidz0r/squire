<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\EventDispatcher;

/**
 * Parameter bag
 * 
 * A parameter bag is a container of key/value pairs. It is not specifically
 * bounded to the EventDispatcher component.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ParameterBag implements \ArrayAccess
{
	/**
	 * @var array The parameters.
	 * @access protected
	 */
	protected $params = array();
	
	/**
	 * Creates a parameter bag from an array.
	 * 
	 * @param array $values The array.
	 * 
	 * @return Squire\EventDispatcher\ParameterBag
	 * @access public
	 */
	static public function fromArray(array $values)
	{
		$bag = new self();
		
		foreach ($values as $key => $value) {
			$bag[$key] = $value;
		}
		
		return $bag;
	}
	
	/**
	 * Returns all the parameters.
	 * 
	 * @return array
	 * @access public
	 */
	public function all()
	{
		return $this->params;
	}
	
	/**
	 * Sets a parameter's value.
	 * 
	 * @param string $name  Parameter's name.
	 * @param mixed  $value Parameter's value.
	 * 
	 * @access public
	 */
	public function set($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	 * Sets a parameter's value using array syntax.
	 * 
	 * @param string $key   Array key.
	 * @param mixed  $value Array value.
	 * 
	 * @access public
	 */
	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}
	
	/**
	 * Returns the given parameter's value.
	 * 
	 * @param string $name Parameter's name.
	 * 
	 * @return mixed
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the parameter doesn't exist.
	 */
	public function get($name)
	{
		if (!$this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" parameter does not exist.',
				$name
			));
		}
		
		return $this->params[$name];
	}
	
	/**
	 * Returns the given parameter's value using array syntax.
	 * 
	 * @param string $key Array key.
	 * 
	 * @return mixed
	 * @access public
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}
	
	/**
	 * Removes a parameter.
	 * 
	 * @param string $name Parameter's name.
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the parameter doesn't exist.
	 */
	public function remove($name)
	{
		if (!$this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" parameter does not exist.',
				$name
			));
		}
		
		unset($this->params[$name]);
	}
	
	/**
	 * Removes a parameter using array syntax.
	 * 
	 * @param string $key Array key.
	 * 
	 * @access public
	 */
	public function offsetUnset($key)
	{
		$this->remove($key);
	}
	
	/**
	 * Returns whether a parameter exists.
	 * 
	 * @param string $name Parameter's name.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function has($name)
	{
		return isset($this->params[$name]);
	}
	
	/**
	 * Returns whether a parameter exists using array syntax.
	 * 
	 * @param string $key Array key.
	 * 
	 * @return boolean
	 * @access public
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}
	
	/**
	 * Removes all the parameters from the bag.
	 * 
	 * @access public
	 */
	public function clear()
	{
		$this->params = array();
	}
}
