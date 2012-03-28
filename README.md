Demo of JqGridBundle
====================

[JqGridBundle](https://github.com/michelpa/JqGridBundle)


Requirement: knp_paginator (included in deps)

+ Clone the repository
+ ./bin/vendors install
+ edit parameters.ini to define a mysql connection
+ ./app/console doctrine:datab:create 
+ ./app/console doctrine:schema:create

Now go to http://yourhost/app_dev.php/gene to generate dummy datas
And then to http://yourhost/app_dev.php/ to see the grid

Everything is in the DefaultController
