health-portal
=============

Mobile portal application demo using Symfony2 framework, jQuery Mobile, Doctrine, etc..

#### Dependencies ####

After cloning the repository, download Symfony2 framework from http://symfony.com/download

and extract ONLY `vendor/` directory to your checkout root.

The reason to do this is that `vendor/` directory is framework-only-code only so no need to store it on github.

#### Web server setup ####

Install Apache 2.2.14 or newer, PHP 5.3.5 or newer, MySQL 5.1.63 or newer.

Point webserver's www-root directory to `path-to-checkout/web/`

#### Pre-run ####

Configure `app/config/parameters.yml` to meet your setup.

Run script `build.sh` on your checkout root.

During build, Doctrine will create database schemas and tables.

#### Run ####

With browser navigate to webserver root.

### Good to know ####

This project uses `prod` environment by default. To fall back to `dev` environment update `web/.htaccess`
RewriteRule -line to point `app_dev.php` instead of current `app.php`

Learn to use Symfony2 http://symfony.com/doc/current/quick_tour
