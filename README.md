Demo of JqGridBundle
====================

[JqGridBundle](https://github.com/michelpa/JqGridBundle)


Requirement: knp_paginator (included in deps)

+ Clone the repository
+ git submodule init
+ git submodule update
+ edit parameters.ini to define a mysql connection
+ ./bin/vendors install
+ ./app/console doctrine:datab:create 
+ ./app/console doctrine:schema:create
+ ./app/console assets:install --symlink web

Now go to http://yourhost/app_dev.php/ to see the grid in action.

Everything is in the DefaultController

<img src="http://i43.tinypic.com/119unnp.png" />
