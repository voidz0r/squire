<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Validation;

/**
 * Input value bag
 * 
 * This class is a container of input values and allows you
 * to validate them all with a single call. It's very useful
 * when you have to deal with superglobal arrays like $_POST,
 * $_GET and $_FILES.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class InputValueBag implements \ArrayAccess, \Countable
{
	/**
	 * The input values.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $values = array();
	
	/**
	 * Adds an input value to the stack.
	 * 
	 * @param string					   $name
	 * @param Squire\Validation\InputValue &$value
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the name is already in use
	 * 
	 * @uses Squire\Validation\InputValueBag::has()
	 */
	public function add($name, InputValue &$value)
	{
		if ($this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" name is already in use.',
				$name
			));
		}
		
		$this->values[$name] = $value;
	}
	
	/**
	 * Provides the same functionalities as `add()`
	 * but using array access syntax.
	 * 
	 * @param string $name
	 * @param mixed  $value
	 * 
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValueBag::add()
	 */
	public function offsetSet($name, $value)
	{
		$this->add($name, $value);
	}
	
	/**
	 * Imports the input values from an array, transforming
	 * each value in an InputValue object (if it isn't) and
	 * using keys as names.
	 * 
	 * @param array  $values
	 * @param string $prefix Optional prefix for names
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If a name is already in use
	 * 
	 * @uses Squire\Validation\InputValueBag::add()
	 */
	public function import(array $values, $prefix = '')
	{
		foreach ($values as $name => $value) {
			$name = "{$prefix}{$name}";
			
			if (!$value instanceof InputValue) {
				$value = new InputValue($value);
			}
			
			$this->add($name, $value);
		}
	}
	
	/**
	 * Returns all the input values.
	 * 
	 * @return array
	 * @access public
	 */
	public function all()
	{
		return $this->values;
	}
	
	/**
	 * Returns the number of registered input values.
	 * 
	 * @return integer
	 * @access public
	 */
	public function count()
	{
		return count($this->all());
	}
	
	/**
	 * Returns the InputValue registered under the given name.
	 * 
	 * @param string $name
	 * 
	 * @return InputValue
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the name is not registered
	 * 
	 * @uses Squire\Validation\InputValueBag::has()
	 */
	public function get($name)
	{
		if (!$this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" name is not registered.',
				$name
			));
		}
		
		$values = $this->all();
		return $values[$name];
	}
	
	/**
	 * Provides the same functionalities as `get()`
	 * but using array access syntax.
	 * 
	 * @param string $name
	 * 
	 * @return mixed
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValueBag::get()
	 */
	public function offsetGet($name)
	{
		return $this->get($name);
	}
	
	/**
	 * Returns whether the given name is registered.
	 * 
	 * @param string $name
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValueBag::all()
	 */
	public function has($name)
	{
		return array_key_exists($name, $this->all());
	}
	
	/**
	 * Provides the same functionalities as `has()`
	 * but using array access syntax.
	 * 
	 * @param string $name
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValueBag::has()
	 */
	public function offsetExists($name)
	{
		return $this->has($name);
	}
	
	/**
	 * Removes the input value registere under the given name.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the name is not registered
	 * 
	 * @uses Squire\Validation\InputValueBag::has()
	 */
	public function remove($name)
	{
		if (!$this->has($name)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" name is not registered.',
				$name
			));
		}
		
		unset($this->values[$name]);
	}
	
	/**
	 * Provides the same functionalities as `remove()` but using
	 * array access syntax.
	 * 
	 * @param string $name
	 * 
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValueBag::remove()
	 */
	public function offsetUnset($name)
	{
		$this->remove($name);
	}
	
	/**
	 * Removes all the input values from the stack.
	 * 
	 * @access public
	 */
	public function clear()
	{
		$this->values = array();
	}
	
	/**
	 * Validates all the input values and returns a multidimensional
	 * associative array with names as keys and arrays of errors as
	 * values.
	 * 
	 * @return array
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValueBag::all()
	 * @uses Squire\Validation\InputValue::validate()
	 */
	public function validate()
	{
		$errors = array();
		
		foreach ($this->all() as $name => $value) {
			$errors[$name] = $value->validate();
		}
		
		return $errors;
	}
}
