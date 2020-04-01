php bin/magento module:enable
php bin/magento setup:upgrade
php bin/magento setup:di:compile

echo ''
echo 'finish'
echo 'next: npm install'
echo '!hint: with sudo if error'
echo 'chown node_modules with yours'
echo ''
echo 'then:'
echo 'hit this command: grunt exec:executive'
echo 'when finish'
echo 'hit this command: grunt less:executive'
echo ''
echo 'keep calm and clear cache'