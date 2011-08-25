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
 * Filter validation constraint
 * 
 * This constraint checks whether the given value validates
 * for the specified PHP filter.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class FilterConstraint implements ConstraintInterface
{
	/**
	 * The filter to use.
	 * 
	 * @var    integer
	 * @access protected
	 */
	protected $filter = 0;
	
	/**
	 * The filter's options.
	 * 
	 * @var    array|integer
	 * @access protected
	 */
	protected $options = array();
	
	/**
	 * Sets the filter to use.
	 * 
	 * @param integer       $filter
	 * @param array|integer $options
	 * 
	 * @return Squire\Validation\Constraint\FilterConstraint
	 * @access public
	 */
	public function __construct($filter, $options = array())
	{
		$this->filter  = $filter;
		$this->options = $options;
	}
	
	/**
	 * Returns the filter to use.
	 * 
	 * @return integer
	 * @access protected
	 */
	public function getFilter()
	{
		return $this->filter;
	}
	
	/**
	 * Returns the filter's options.
	 * 
	 * @return array|integer
	 * @access public
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Validates the given value against the specified filter
	 * using `filter_var()`.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\Validation\Constraint\FilterConstraint::getFilter()
	 * @uses Squire\Validation\Constraint\FilterConstraint::getOptions()
	 */
	public function isValid($value)
	{
		return (bool)filter_var($value, $this->getFilter(), $this->getOptions());
	}
}
