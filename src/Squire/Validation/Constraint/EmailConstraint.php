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
 * Email validation constraint
 * 
 * This constraint checks whether the given value is an
 * email.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * @todo Implement MX record check
 */
class EmailConstraint extends FilterConstraint
{
	/**
	 * The constructor does no longer accept parameters.
	 * 
	 * @return Squire\Validation\Constraint\EmailConstraint
	 * @access public
	 * 
	 * @uses Squire\Validation\Constraint\FilterConstraint::__construct()
	 */
	public function __construct()
	{
		parent::__construct(FILTER_VALIDATE_EMAIL);
	}
}
