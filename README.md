health-portal
=============

Mobile portal demo application using:
* Symfony2 framework http://symfony.com
* jQuery Mobile http://jquerymobile.com
* Twig template engine http://twig.sensiolabs.org
* Doctrine persisting services http://www.doctrine-project.org
* etc..

#### Dependencies ####

* PHP 5.3.5 or newer

#### Clone ####

After cloning the repository, download Symfony2 framework from http://symfony.com/download

and extract ONLY `vendor/` directory to your checkout root.

The reason to do this is that `vendor/` directory is framework-only-code only so no need to store it on github.

#### Web server setup ####

Install Apache 2.2.14 or newer, PHP 5.3.5 or newer, MySQL 5.1.63 or newer.

Point webserver's www-root directory to `path-to-checkout/web/`

#### Pre-run ####

Configure `app/config/parameters.yml` to meet your setup.

Edit `build.sh` file lines chmod; set correct webserver user, if not www-data.

Run script `build.sh` on your checkout root.

During build, Doctrine will create database schemas and tables.

#### Run ####

With browser navigate to webserver root.

### Good to know ####

This project uses `prod` environment by default. To fall back to `dev` environment update `web/.htaccess`
RewriteRule -line to point `app_dev.php` instead of current `app.php`

Inter-bundle resources are stored in `src/Enymind/Bundle/Health/WelcomeBundle/Resources/public/`

Base view is located at `app/Resources/views/base.html.twig`

Learn to use Symfony2 http://symfony.com/doc/current/quick_tour
