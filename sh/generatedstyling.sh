rm -rf var/view_preprocessed
rm -rf var/generation
rm -rf var/log/system.log
rm -rf pub/static
php -dmemory_limit=1G bin/magento setup:static-content:deploy -t en_US -f
php -dmemory_limit=1G bin/magento setup:static-content:deploy -t id_ID -f
