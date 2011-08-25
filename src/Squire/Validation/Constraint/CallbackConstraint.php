<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Validation\Constraint;

/**
 * Callback validation constraint
 * 
 * This constraint checks that the given callback returns
 * TRUE when the given value is specified as parameter.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class CallbackConstraint implements ConstraintInterface
{
	/**
	 * The callback.
	 * 
	 * @var    callback
	 * @access protected
	 */
	protected $callback = null;
	
	/**
	 * Additional parameters for the callback.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $params = array();
	
	/**
	 * Sets the callback to use.
	 * 
	 * @param callback $callback
	 * @param array    $params   Additional parameters
	 * 
	 * @return Squire\Validation\Constraint\CallbackConstraint
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the callback is invalid
	 */
	public function __construct($callback, array $params = array())
	{
		$this->callback = $callback;
		$this->params   = $params;
		
		if (!is_callable($callback, false, $readable_callback)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is an invalid callback.',
				$readable_callback
			));
		}
	}
	
	/**
	 * Returns the callback to use.
	 * 
	 * @return callback
	 * @access public
	 */
	public function getCallback()
	{
		return $this->callback;
	}
	
	/**
	 * Returns the additional parameters.
	 * 
	 * @return array
	 * @access public
	 */
	public function getParams()
	{
		return $this->params;
	}
	
	/**
	 * Checks whether the callback returns TRUE if the
	 * value is specified as the first parameter.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isValid($value)
	{
		$params = array($value);
		$params = array_merge($params, $this->getParams());
		
		return (bool)call_user_func_array($this->getCallback(), $params);
	}
}
