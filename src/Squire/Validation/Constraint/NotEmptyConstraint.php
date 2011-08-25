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
 * Not empty validation constraint
 * 
 * This constraint checks whether the given value is not
 * empty.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class NotEmptyConstraint implements ConstraintInterface
{
	/**
	 * Returns whether the given value is not empty.
	 * 
	 * @param mixed $value
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isValid($value)
	{
		return !empty($value);
	}
}
