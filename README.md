Squire
======

**Squire** is a PHP Web framework. It provides a rich set of libraries which
allow a developer to focus just on its project main functionalities.

The framework is splitted into components. Each *component* is a set of PHP
classes that provide a specific functionality to your application. There
could be a component to handle, for example, routing.

Why should I use Squire?
------------------------

Here are the reasons for the which you should use **Squire**:

   * Use of PHP5 advanced functionalities like namespaces and autoloading.
   * All the classes are completely unit-tested using PHPUnit.
   * The source code follows the PEAR coding standards.
   * Released under the **GNU General Public License**.

How should I use Squire?
------------------------

You don't have to use all of the components. You can also pick just the ones
you need and include them in an existing application.

In order to use **Squire**, you must include the autoloader first:

	<?php
	require_once '/path/to/squire/src/autoload.php';
	
	// ...
	?>

How can I test Squire?
----------------------

**Squire** is completely unit-tested using the [PHPUnit](http://phpun.it)
framework. In order to test that everything is working properly, open a shell
and type the following commands:

	$ cd /path/to/squire
	$ phpunit tests/

You should see a green **OK**. If you get any error messages, try downloading
the framework again. If the problem persists, contact the authors.

