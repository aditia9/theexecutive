## <h2>Welcome</h2>
Welcome to Magento 2 installation! We're glad you chose to install Magento 2, a cutting edge, feature-rich eCommerce solution that gets results.

## Magento system requirements
**make sure you have meet at least minimum requierment of magento 2.2 requierements** 
[Magento system requirements](http://devdocs.magento.com/magento-system-requirements.html)

## Install Magento
To install Magento, see either:
💡[Magento DevBox](https://magento.com/tech-resources/download), the easiest way to get started with Magento.
💡[Installation guide](http://devdocs.magento.com/guides/v2.0/install-gde/bk-install-guide.html)

## Quick Guide:
**Make sure you have magento developer keys regarding for composer install.**

Follow this command on root project folder:
1. composer install
2. composer update
3. npm install
4. php bin/magento module:enable --all
5. php bin/magento setup:upgrade
6. php bin/magento setup:di:compile
7. php bin/magento setup:static-content:deploy
8. grunt exec
9. grunt less
10. php bin/magento indexer:reindex
11. php bin/magento cache:clean

everytime makes a code changes related to data on database please run **php bin/magento setup:upgrade** then **php bin/magento setup:static-content:deploy**

and everything changes related to styling, you need to run **grunt less**. and if you add new .less files, you need to run **grunt exec** to create a symlink of your .less files into pub folder.

### DO NOT EDIT FILES DIRECTLY FROM APP/CODE/MAGENTO

## Database
[Download Database](https://www.dropbox.com/s/4l33c6m0wgfwgct/delami_executive_data_2018-02-18.sql.zip?dl=0) __edit table core_config_data__ find __web/unsecure/base_url__ and __web/secure/base_url__ to your domain.

## env.php Sample
[Download env.php Sample](https://www.dropbox.com/s/x8x7e3lexu809od/env.php?dl=0) **extract on __app/etc/__**

## Download Banner Sample
[Download Image](https://www.dropbox.com/s/3mbhchd0ewnhiqb/wysiwyg.zip?dl=0) **extract on __pub/media/wysiwyg__**