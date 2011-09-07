<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Routing;

/**
 * Route compiler
 * 
 * A route compiler takes a route as input argument and returns a
 * CompiledRoute object that can be used with a matcher.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class RouteCompiler
{
	/**
	 * Compiles the route, retunring a CompiledRoute object.
	 * 
	 * @param Squire\Routing\Route &$route The route to compile.
	 * 
	 * @return Squire\Routing\CompiledRoute
	 * @access public
	 */
	public function compile(Route &$route)
	{
		return new CompiledRoute($route, $this->compileRegex($route));
	}
	
	/**
	 * Compiles the route, returning a regular expression.
	 * 
	 * @param Squire\Routing\Route &$route The route to compile.
	 * 
	 * @return string
	 * @access public
	 */
	public function compileRegex(Route &$route)
	{
		$regex = preg_replace_callback('/\{(\w+)\}/',
			function(array $matches) use($route) {
				$param = substr($matches[0], 1, -1);
				
				$pattern = '';

				if ($route->hasRequirement($param)) {
					$pattern .= '('. $route->getRequirement($param) . ')';
				}
				else {
					$pattern .= '([a-zA-Z0-9_\+\-%]+)';
				}
				
				if ($route->hasDefault($param)) {
					$full_pattern = '@^' . $pattern . '$@';
					
					$match = preg_match(
						$full_pattern,
						$route->getDefault($param)
					);
					
					if (!$match) {
						throw new \InvalidArgumentException(sprintf(
							'"%s" default value for "%s" parameter does not ' .
							'match the "%s" requirements.',
							$route->getDefault($param),
							$param,
							$route->getRequirement($param)
						));
					}
					
					$pattern = "?{$pattern}?";
				}
				
				return $pattern;
			}, $route->getPattern());
			
		$regex = '@^' . $regex . '/?$@';
		return $regex;
	}
}
