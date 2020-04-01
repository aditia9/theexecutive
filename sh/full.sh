php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -t Delami/executive en_US id_ID
grunt exec:executive_en
grunt less:executive_en
grunt exec:executive_id
grunt less:executive_id
php bin/magento cache:clean