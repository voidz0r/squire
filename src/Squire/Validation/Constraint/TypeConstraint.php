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
 * Type validation constraint
 * 
 * Checks whether the given value is of the specified
 * type.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class TypeConstraint implements ConstraintInterface
{
	/**
	 * The type to expect.
	 * 
	 * @var    string
	 * @access protected
	 */
	protected $type = '';
	
	/**
	 * Sets the type to expect.
	 * 
	 * @param string $type A value returned by `gettype()`
	 * 
	 * @return Squire\Validation\Constraint\TypeConstraint
	 * @access public
	 */
	public function __construct($type)
	{
		$this->type = $type;
	}
	
	/**
	 * Returns the expected type.
	 * 
	 * @return string
	 * @access public
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Checks whether the given value is of the specified
	 * type.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\Validation\Constraint\TypeConstraint::getValue()
	 */
	public function isValid($value)
	{
		return gettype($value) === $this->getType();
	}
}
