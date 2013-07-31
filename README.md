StartInGent
=========

*Copyright Stefaan Christiaens, some rights reserved.*



StartInGhent is a webapplication for people moving to Ghent. 
With this tool they can find out in what neighbourhood they would fit best.

Made with PHP Zend Framework 1.12 and codeinchaos/restful-zend-framework for the API in Zend


How to set up
--------
Import database in PhpMyAdmin from /docs
Create folders:
- /public/images
- /public/config

In /public/config create a config.php

    <?php
      define('START_IN_GHENT_SALT', '');
      define('START_IN_GHENT_PWD', '');
And fill in a unique salt, and the password of the mailaccount you will be sending from.
