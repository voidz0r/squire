Squire
======

What is Squire?
---------------

It's been four years since I began developing with PHP, and, altough many lacks
were filled during this time, I found out that a lot of library are still
missing, ore the existing ones are bad-written. So I decided to create
**Squire**, a set of classes which automate common tasks for PHP applications.

Said shorter: "**Squire** is a library for PHP developers who don't want to
reinvent the wheel each time they start a new project".

What functionalities does Squire provide?
-----------------------------------------

These are the components that make **Squire**:

   * 	**ClassLoader**: an autoloader that allows you to use naming standards
   		in your project. It's very similar to **Symfony\Component\ClassLoader**,
   		but it has been written from scratch using a cleaner syntax.
   * 	**DependencyInjection**: this one allows you to use service containers
   		in your project, so that you can get rid of global variables and even
		singletons. Just register a service, set some parameters and use it.
   * 	**Validation**: this component allows you to validate user's input.

What functionalities will Squire provide in the near future?
------------------------------------------------------------

The following components may be developed in the future:

   * 	**Routing**: a component to handle routing in your application.
   		Basically, it maps a URI (e.g. ```/blog/show/1```) to a callback
   		(e.g. ```BlogController::showAction(1)```). Routing is used in MVC
   		frameworks.
   * 	**Http**: a component to handle HTTP requests/responses. It will support
   		headers/cookies manipulations and a lot more.

Why should I use Squire?
------------------------

These are the things that make **Squire** different from other libraries:

   * 	Use of PHP 5.3 namespace naming conventions
   * 	Use of autoloading (you won't need to include library files anymore!)
   * 	Use of PEAR coding standards (very clean and well-formatted code)
   *	Very well-documented public API
   * 	Fully unit-tested using [PHPUnit](http://phpunit.de)
   * 	Released under the
   		[GNU General Public License](http://www.gnu.org/licenses/gpl.txt)

How can I contribute?
---------------------

**Squire** is an open source project, so you're free to contribute. I don't
want any donations. If you want to help me, take your laptop and start coding!
When you have finished, submit a PR (Pull Request) to our
[GitHub repository](http://github.com/alessandro1997/squire).

Installing
----------

### Through Git
**Squire** is hosted by [GitHub](http://github.com), so if you have installed
Git on your machine you can install it by typing the following commands in the
console:

	$ cd /path/to/project/vendor
	$ git clone http://github.com/alessandro1997/squire.git

This will install **Squire** under the **vendor/squire** directory in your
project's root directory.

### Downloading the tarball

You can download the packaged version of **Squire** (in .tar.gz format) from
our [GitHub repository](http://github.com/alessandro1997/squire).

Using a component
-----------------

You will have to include the autoloader in your project by adding the following
snippet at the top of your front controller (note: if you don't have a front
controller you'll have to add it at the top of each file using a **Squire**'s
component!):

```php
require_once '/path/to/squire/src/autoload.php';
```

After this you'll be able to use a component using standard class syntax:

```php
use Squire\Component\ClassLoader\UniversalLoader;

$loader = new UniversalLoader();
// ...
```

Or you can specify the full class name:

```php
$loader = new Squire\Component\ClassLoader\UniversalLoader();
// ...
```

We hope you'll find comfortable with **Squire**!
