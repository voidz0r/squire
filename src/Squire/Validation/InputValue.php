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

use Squire\Validation\Constraint\ConstraintInterface;

/**
 * Input value
 * 
 * An instance of this class represents a value given by
 * the user that must be validated using one or more
 * validation constraints.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class InputValue
{
	/**
	 * The value itself.
	 * 
	 * @var    mixed
	 * @access protected
	 */
	protected $value = null;
	
	/**
	 * The validation constraints.
	 * 
	 * @var    array
	 * @access protected
	 */
	protected $constraints = array();
	
	/**
	 * Sets the input value.
	 * 
	 * @param mixed $value
	 * 
	 * @return Squire\Validation\InputValue
	 * @access public
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	/**
	 * Returns the input value.
	 * 
	 * @return mixed
	 * @access public
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Adds a validation constraint to the stack.
	 * 
	 * @param Squire\Validation\Constraint\ConstraintInterface &$constraint
	 * @param string										   $error
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the constraint has been already added
	 * 
	 * @uses Squire\Validation\InputValue::hasConstraint()
	 */
	public function addConstraint(ConstraintInterface &$constraint, $error)
	{
		if ($this->hasConstraint($constraint)) {
			throw new \InvalidArgumentException(sprintf(
				'Same instance of "%s" already added to the stack.',
				get_class($constraint)
			));
		}
		
		$this->constraints[] = array(
			'constraint' => $constraint,
			'error'      => $error,
		);
	}
	
	/**
	 * Returns all the validation constraints.
	 * 
	 * @return array
	 * @access public
	 */
	public function getConstraints()
	{
		return $this->constraints;
	}
	
	/**
	 * Returns whether the given constraint is in the stack.
	 * 
	 * @param ContainerInterface &$constraint
	 * 
	 * @return boolean
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValue::getConstraints()
	 */
	public function hasConstraint(ConstraintInterface &$constraint)
	{
		foreach ($this->getConstraints() as $constr) {
			if ($constraint === $constr['constraint']) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Removes all the constraints from the stack.
	 * 
	 * @access public
	 */
	public function clearConstraints()
	{
		$this->constraints = array();
	}
	
	/**
	 * Validates the input value against all the constraints and
	 * returns an array containing the errors.
	 * 
	 * @return array
	 * @access public
	 * 
	 * @uses Squire\Validation\InputValue::getConstraints()
	 * @uses Squire\Validation\ConstraintInterface::isValid()
	 */
	public function validate()
	{
		$errors = array();
		
		foreach ($this->getConstraints() as $constraint) {
			if (!$constraint['constraint']->isValid($this->getValue())) {
				$errors[] = $constraint['error'];
			}
		}
		
		return $errors;
	}
}
