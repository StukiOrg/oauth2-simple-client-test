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


