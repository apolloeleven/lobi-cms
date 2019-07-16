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
    

### Storage and Database synchronization

To download the storage and database from production or test server run the following command.
 
**Important**:
In order synchronization of database to work you need to create `.my.cnf` file to access
the database by just typing `mysql`. 

```shell
php console/yii test/sync $username $host $port = [22]
```

This will:
 
  - authenticate to the server by ssh
  - make the database dump
  - make the `*.tar.gz` archive file of the `storage/web/source`
  - download the dump and storage archive file by scp command 
  - extract the storage into `storage/web/source` folder
  - restore the dump into current database
  
## MultiSite
 
 1.  Run migration
     ```bash 
     ./migrate
     ```    
 1.  For switch language from 'en' to 'en-US' 
     ```bash 
     php console/yii utils/switch-language en en-US
     ```    
     <b>Run output SQL String from DB console than continue!!!!</b>
     
 1.  Read languages from multiSiteCore websites and insert it in language table
      ```bash 
      php console/yii sync/languages 
      ```   
 1.  Add website in contentTree
       ```bash 
       php console/yii sync/websites 
       ```       
 1.  For copy content
     ```bash 
     php console/yii utils/copy-language $fromWebsiteKey $toWebsiteKey $from $to
     ```                  
     <b>Run output SQL String from DB console than continue!!!!</b>
     
 1.  For add language content content
     ```bash 
     php console/yii utils/add-language $websiteKey $from $to
     ```                  
     <b>Run output SQL String from DB console than continue!!!!</b>
