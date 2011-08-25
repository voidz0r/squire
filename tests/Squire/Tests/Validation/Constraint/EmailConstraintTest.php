<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\Validation\Constraint;

use Squire\Validation\Constraint\EmailConstraint;

/**
 * Tests for `Squire\Validation\Constraint\EmailConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\EmailConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class EmailConstraintTest extends TestCase
{
	/**
	 * Tests for `testValidation()`.
	 * 
	 * @return array
	 * @access public
	 */
	public function getValidationTests()
	{
		return array(
			array(
				// constraint object
				new EmailConstraint(),
				
				// results
				array(
					// result
					array(
						// value
						'value' => 'foo@bar.baz',
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => 'foo@bar',
						
						// result
						'result' => false,
					),
				),
			),
		);
	}
}
