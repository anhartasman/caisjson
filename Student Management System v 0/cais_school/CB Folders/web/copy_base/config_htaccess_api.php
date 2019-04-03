RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond $1 !^(index\.php|images)
RewriteRule ^(.*)$ /{cais_web_folder}/API/index.php?$1 [L]
