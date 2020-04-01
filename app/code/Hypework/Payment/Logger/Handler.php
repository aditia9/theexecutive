<?php

/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/10/18
 * Time: 8:41 PM
 */
namespace Hypework\Payment\Logger;
//use Monolog\Logger;
class Handler extends \Magento\Framework\Logger\Handler\Base
{
    protected $loggerType = Logger::DEBUG;
    protected $fileName = '/var/log/payments.log';
}