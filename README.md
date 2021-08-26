#Tiny URL Service

Front End:<br>
HTML<br>
JavaScript<br>

Back End:<br>
PHP 7.0<br>
MySQL<br>

Included Packages:<br>
jQuery 3.3.1<br>
Bootstrap 4.1.3<br>
FontAwesome 4.7.0<br>

Host: <br>
Amazon EC2 RH Instance<br>
Apache 2.4<br>

This is a basic URL shortner application that allow pass through and tracking for URLs.
A full length URL is added to the site, and then given a unique key and saved into the database.
If a given URL is already in the database, the unique key will remain the same and be given to the user.
When a shortened URL is used, the user's information can be saved (IP Address, ISP, etc).
An .htaccess file is required to handle the URL and the unique key after the trailing '/'.


