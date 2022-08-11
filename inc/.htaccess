RewriteEngine On
RewriteCond %{THE_REQUEST} /([^.]+)\.php [NC]
RewriteRule (.*) /%1 [R=302,L]  
RewriteCond %{REQUEST_FILENAME}\.php -f
RewriteRule ^(.*)$ $1.php