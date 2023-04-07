# Range Products - Module for Magento 2

IMPORTANT: IT'S JUST A TEST MODULE, THERE WILL BE NO MAINTENANCE IN THE FUTURE

## Description
This module adds a new section to the customer account that the client can access and filter products by the low range price and high range price.

## Installation

The extension can be installed via `composer`. To proceed, run these commands in your terminal:

```
composer require tesche/rangeproducts
php bin/magento module:enable Tesche_RangeProducts
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## How to use

You can find the option on the Side menu from the Customer Account page (www.example.com/customer/account/)