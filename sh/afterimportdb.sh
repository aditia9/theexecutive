php bin/magento setup:upgrade
grunt exec:executive_en
grunt exec:executive_id
grunt less:executive_en
grunt less:executive_id
php bin/magento indexer:reindex
php bin/magento cache:clean 
#echo 'reverting permission 755'
#find . -type d -exec chmod 0755 {} \;
#echo 'reverting permission 644'
#find . -type f -exec chmod 0644 {} \;
echo 'finish'