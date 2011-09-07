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
 * Route URI matcher
 *
 * Given a compiled route, this class can tell you whether a given URI matches
 * it and what are the parameter's values it contains.
 *
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class UriMatcher
{
    /**
     * @var Squire\Routing\CompiledRoute The compiled route to match against.
     * @access protected
     */
    protected $compiled = null;

    /**
     * Injects the compiled route into the matcher.
     *
     * @param Squire\Routing\CompiledRoute &$compiled The compiled route.
     *
     * @return Squire\Routing\UriMatcher
     * @access public
     */
    public function __construct(CompiledRoute &$compiled)
    {
        $this->compiled = $compiled;
    }

    /**
     * Returns the compiled route to match against.
     *
     * @return Squire\Routing\CompiledRoute
     * @access public
     */
    public function getCompiledRoute()
    {
        return $this->compiled;
    }

    /**
     * If the given URI matches the compiled route, returns an associative
     * array containing the parameters' values. If it doesn't, returns FALSE.
     *
     * @param string $uri The URI to check.
     *
     * @return array|boolean
     * @access public
     */
    public function match($uri)
    {
        $match = preg_match(
            $this->getCompiledRoute()->getRegex(),
            $uri,
            $p_values
        );

        if ($match) {
            array_shift($p_values);

            preg_match_all(
                '/\{(\w+)\}/',
                $this->getCompiledRoute()->getRoute()->getPattern(),
                $p_names,
                PREG_PATTERN_ORDER
            );

            $p_names = $p_names[0];

            $params = array();
            foreach ($p_values as $index => $value) {
                $params[substr($p_names[$index], 1, -1)] = $value;
            }

            $params = array_merge(
                $this->getCompiledRoute()->getRoute()->getDefaults(),
                $params
            );

            return $params;
        }

        return false;
    }
}
