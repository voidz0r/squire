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

use Squire\Validation\Constraint\ChoiceConstraint;

/**
 * Tests for `Squire\Validation\Constraint\ChoiceConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\ChoiceConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ChoiceConstraintTest extends TestCase
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
				new ChoiceConstraint(array('foo', 'bar')),
				
				// results
				array(
					// result
					array(
						// value
						'value' => 'foo',
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => 'bar',
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => 'baz',
						
						// result
						'result' => false,
					),
				),
			),
		);
	}
}
