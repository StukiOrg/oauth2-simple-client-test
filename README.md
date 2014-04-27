OAuth2 Client Provider Test for league/oauth2-client
====================================================

Introduction
------------
OAuth2 implementations on smaller providers have a tendancy to change, thereby 
breaking libraries like oauth2-client, often times because routes change, but 
for any number of reasons.

So, in order to properly test each provider the whole OAuth2 process must be manually
walked-through.  This app walks through each provider in turn and runs the oauth2
process.


Configuration
-------------

Copy ```config/autoload/local.php.dist``` to ```config/autoload/local.php``` Next create an application for yourself on every provider and/or add every providers clientId and clientSecret and redirectUri to your local.php.  You should configure each Provider's redirectUri to an alias in your hosts file, and to a specific port such as 8080. 


Testing
-------

Run the application from the command line: ```php -S api.myhostalias.com:8080 -t public/ public/index.php```

Browse to http://api.myhostalias.com:8080 and use the buttons to test each service.
