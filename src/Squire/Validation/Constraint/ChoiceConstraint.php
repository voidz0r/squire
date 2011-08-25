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
 * Choice validation constraint
 * 
 * This constraint checks that the value is one of the
 * specified ones.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ChoiceConstraint implements ConstraintInterface
{
	/**
	 * The possible values.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $choices = array();
	
	/**
	 * Sets the possible values.
	 * 
	 * @param array $choices
	 * 
	 * @return Squire\Validation\Constraint\ChoiceConstraint
	 * @access public
	 */
	public function __construct(array $choices)
	{
		$this->choices = $choices;
	}
	
	/**
	 * Returns the possible values.
	 * 
	 * @return array
	 * @access public
	 */
	public function getChoices()
	{
		return $this->choices;
	}
	
	/**
	 * Checks whether the given value equals one of
	 * the choices.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\Validation\Constraint\ChoiceConstraint::getChoices()
	 */
	public function isValid($value)
	{
		return in_array($value, $this->getChoices());
	}
}
