# Lobi CMS

<!-- BADGES/ -->

<!-- /BADGES -->

Fast, secure and user friendly CMS with "Frontend Editing" tool, based on Yii2 framework.
 
We started with the [Yii2 starter kit](https://github.com/trntv/yii2-starter-kit).

The CMS uses [Lobiadmin](http://lobianijs.com/site/lobiadmin) as an html admin template for its backend.

## Installation
1. Clone the project and go to the project root directory
2. Run `composer install`. After this process is finished, it will ask you to provide configuration parameters. 
For most of them you can leave them default, but make sure you have correct parameters for database access. 
(You can leave all parameters default and change them later from `.env` file)
3. Run `./setup` bash file which will create database (If it does not exist) and run migration scripts.



## Console Commands
1.  For Synchronize Search. Filling search table for backend search 
    ```bash
    php console/yii sync/search
    ```
1. For Synchronize Slug  
    ```bash
    php console/yii sync/slug
    ```
1. For importing translations for frontend from all frontend files run following command 
    ```bash
    php console/yii message common/config/messages/frontend.php 
    ```      