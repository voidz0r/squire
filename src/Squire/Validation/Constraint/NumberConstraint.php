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
 * Number validation constraint
 * 
 * This constraint performs various checks on numbers.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class NumberConstraint implements ConstraintInterface
{
	/**
	 * The minimum value.
	 * 
	 * @var    integer|boolean
	 * @access protected
	 */
	protected $min = false;
	
	/**
	 * The maximum value.
	 * 
	 * @var    integer|boolean
	 * @access protected
	 */
	protected $max = false;
	
	/**
	 * Sets the minimum value (FALSE to disable).
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
	 * Returns the minimum value (FALSE if disabled).
	 * 
	 * @return integer|boolean
	 * @access public
	 */
	public function getMin()
	{
		return $this->min;
	}
	
	/**
	 * Sets the maximum value (FALSE to disable).
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
	 * Returns the maximum value (FALSE if disabled).
	 * 
	 * @return integer|boolean
	 * @access public
	 */
	public function getMax()
	{
		return $this->max;
	}
	
	/**
	 * Checks that the value is numeric. If a range has been
	 * specified, also checks that the value is in that range.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isValid($value)
	{
		if (!is_numeric($value)) {
			return false;
		}
		
		if ($this->getMin() !== false && $value < $this->getMin()) {
			return false;
		}
		
		if ($this->getMax() !== false && $value > $this->getMax()) {
			return false;
		}
		
		return true;
	}
}
