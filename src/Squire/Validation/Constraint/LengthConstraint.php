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
 * Length validation constraint
 * 
 * This constraint checks whether the given value's length
 * is in the specified range.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class LengthConstraint implements ConstraintInterface
{
	/**
	 * The minimum length.
	 * 
	 * @var    integer|boolean
	 * @access protected
	 */
	protected $min = false;
	
	/**
	 * The maximum length.
	 * 
	 * @var    integer|boolean
	 * @access protected
	 */
	protected $max = false;
	
	/**
	 * Sets the minimum length (FALSE to disable).
	 * 
	 * @param integer\boolean $min
	 * 
	 * @access public
	 */
	public function setMin($min)
	{
		$this->min = $min;
	}
	
	/**
	 * Returns the minimum length (FALSE if disabled).
	 * 
	 * @return integer|boolean
	 * @access public
	 */
	public function getMin()
	{
		return $this->min;
	}
	
	/**
	 * Sets the maximum length (FALSE to disable).
	 * 
	 * @param integer|boolean $max
	 * 
	 * @access public
	 */
	public function setMax($max)
	{
		$this->max = $max;
	}
	
	/**
	 * Returns the maximum length (FALSE if disabled).
	 * 
	 * @return integer|boolean
	 * @access public
	 */
	public function getMax()
	{
		return $this->max;
	}
	
	/**
	 * Checks whether the value's length is correct.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @throws \LogicException If both minimum and maximum values were not set
	 */
	public function isValid($value)
	{
		if ($this->getMin() === false && $this->getMax() === false) {
			throw new \LogicException('You must specify at least one length for the range.');
		}
		
		if ($this->getMin() !== false && strlen($value) < $this->getMin()) {
			return false;
		}
		
		if ($this->getMax() !== false && strlen($value) > $this->getMax()) {
			return false;
		}
		
		return true;
	}
}
