php-sql-no-inject
=================

PHP SQL no inject - possible to remove sql injection

Usage:
-----------
1. include this file at the top of your PHP scripts
<?php
    include_once("./php-sql-no-inject.php");
?>

2. set auto_prepend to this file
;php.ini
auto_prepend_file = 'php-sql-no-inject.php';
