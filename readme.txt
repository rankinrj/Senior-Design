This is the 2017-2018 Study Abroad Calculator senior design project frrom Miami University.


Setup: (note the directory may need to be renamed to quickstart)
Clone the git repository from https://github.com/rankinrj1/Senior-Design.git.
Run the composer with composer install.
Allow laravel to make changes from the apache config files.
Create the database using mysql and the provided creation.txt
If you have changed the names of any components of the database you will have to make changes to the .env file and possible the database config file as well.
Run php artisan serve.

Routes:
All routes are at appp/Http/routes.php

Views:
Views are located at resources/views and annotated with .blade.php
Important views are crud.blade.php and calc.blade.php. In addition there is a test.blade.php for testing potential changes to clac.blade.php.
