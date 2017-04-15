Versioner is a simple versioning microservice, useful for maintaining an ever incrementing integer across builds created by a team of people. It's built on the Slim framework and stores the information in an SQLite database,

The use cases vary, but the most common would be to install it on your network on a web server (or a public facing webserver).

Interacting with this microservice can be done over REST with the following APIs:

POST /version

Sets the version to a certain value or bumps the current version.

POST parameters:
- application_id: String (e.g. net.example.app).
- secret: String - an application specific secret.
- version: Int - optional - if not specified, the current version will be bumped.

GET /version/{application_id}/{secret}

Returns the current version for a given application ID.

POST /manage/add

Adds a new application to the database.

POST parameters
- application_id: String (e.g. net.example.app).
- secret: String - an application specific secret.

Installation instructions

1. Download or clone this project in a location not accessible by by URL.

2. Install composer

3. Run `composer install`

4. Copy versioner.dist.db to versioner.db

5. Make the storage folder and versioner.db writable.

6. Make the logs folder writable.

7. Copy the index.php file from the public folder to a publicly accessible location. For example, if you want to server the Versioner from https://example.org/versioner/, you will create a `versioner` folder in the public root and add it there. 

Edit the contents of the index.php file so it can resolve the paths it references. Normally you'd replace "../" with something like "../../versioner", if the non-publicly available files were stored one level above the web root, in a versioner folder.

8. If you're using Apache, you'll need to following .htaccess file. This should be placed next to index.php above.

```RewriteEngine on
RewriteCond $1 !^(index\.php)

RewriteBase /versioner/
RewriteRule ^(.*)$ index.php/$1 [L]```

If you install it in a different flder (or /) edit the path above.

9. If you're using nginx, add the following settings:

...

10. If you're using any of the above, but don't care about pretty URLs or don't want to bother with .htaccess, you can also access the Versioner through https://example.org/versioner/index.php/version/APPLICATION_ID/SECRET