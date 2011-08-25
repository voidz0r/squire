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
 * Validation constraint interface
 * 
 * This interface must be implemented by all the validation
 * constraints.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
interface ConstraintInterface
{
	/**
	 * Returns whether the value validates for the constraint.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isValid($value);
}
