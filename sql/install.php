<?php
/**
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'cities` (
    `id_city` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'history` (
    `id_history` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `cityId` INT(11) NOT NULL,
    `api` VARCHAR(100) NOT NULL,
    `temperature` FLOAT,
    `humidity` FLOAT,
    `createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`cityId`) REFERENCES `' . _DB_PREFIX_ . 'cities`(`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4;';

$sql[] = 'INSERT INTO `' . _DB_PREFIX_ . 'cities` (`name`) VALUES
("New York"),
("Los Angeles"),
("Chicago"),
("San Jose"),
("London"),
("Paris"),
("Berlin"),
("Munich"),
("Frankfurt"),
("Madrid"),
("Barcelona"),
("Naples"),
("Venice"),
("Athens"),
("Vienna"),
("Brussels"),
("Porto");';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
