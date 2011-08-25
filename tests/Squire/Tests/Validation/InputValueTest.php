<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\Validation;

use Squire\Tests\TestCase;
use Squire\Validation\InputValue;
use Squire\Validation\Constraint\TypeConstraint;
use Squire\Validation\Constraint\ChoiceConstraint;
use Squire\Validation\Constraint\NumberConstraint;

/**
 * Tests for `Squire\Validation\InputValue`
 * 
 * This class checks that the `Squire\Validation\InputValue`
 * class works correctly.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class InputValueTest extends TestCase
{
	/**
	 * Tests that the input value is validated correctly.
	 * 
	 * @param mixed $value
	 * @param array $constraints
	 * 
	 * @access public
	 * 
	 * @dataProvider getValidationTests
	 */
	public function testValidation($value, array $constraints)
	{
		$inputv = new InputValue($value);
		
		$errors = array();
		foreach ($constraints as $constraint) {
			$inputv->addConstraint($constraint['constraint'], $constraint['error']);
			
			if (!$constraint['constraint']->isValid($value)) {
				$errors[] = $constraint['error'];
			}
		}
		
		$validation = $inputv->validate();
		$this->assertEquals($errors, $validation);
	}
	
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
				// value
				'bar',
				
				// constraints
				array(
					// constraint
					array(
						// constraint object
						'constraint' => new TypeConstraint('string'),
						
						// error message
						'error'		 => 'The value is not a string.',
					),
					
					// constraint
					array(
						// constraint object
						'constraint' => new ChoiceConstraint(array('foo', 'bar')),
						
						// error message
						'error'		 => 'The value is not foo or bar.',
					),
					
					// constraint
					array(
						// constraint object
						'constraint' => new NumberConstraint(),
						
						// error message
						'error'		 => 'The value is not numeric.',
					),
				),
			),
		);
	}
}
