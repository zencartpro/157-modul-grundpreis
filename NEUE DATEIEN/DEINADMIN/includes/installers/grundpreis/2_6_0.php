<?php
/**
 * @package Grundpreis
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 2_6_0.php 2022-04-12 09:56:51Z webchills $
 */


$db->Execute("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key LIKE '%SHOW_BASE_UNIT_PRICE%';");
$db->Execute("DELETE FROM ".TABLE_CONFIGURATION_LANGUAGE." WHERE configuration_key LIKE '%SHOW_BASE_UNIT_PRICE%';");

$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Grundpreisanzeige'
LIMIT 1;");


$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, last_modified, use_function, set_function) VALUES
('Show Base Unit Price', 'SHOW_BASE_UNIT_PRICE', '0', 'Do you want to show the base unit price<br />0= off<br />1 = everywhere : product listing, all products, new products, product info<br />2 = Only on product info page', @gid, 1, now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(\'id\'=>\'0\', \'text\'=>\'Off\'), array(\'id\'=>\'1\', \'text\'=>\'Everywhere\'), array(\'id\'=>\'2\', \'text\'=>\'Product info only\')),')");


$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('Grundpreisanzeige', 'SHOW_BASE_UNIT_PRICE', 'Wollen Sie den Grundpreis anzeigen?<br />0 = Off = Nein<br />1 = Everywhere = auf allen Seiten (Artikelliste, Alle Artikel, Neue Artikel, Artikeldetailseite)<br />2 = Product info only = Nur auf der Artikeldetailseite', 43)");


//check if products_base_unit_price column already exists - if not add it
    $sql ="SHOW COLUMNS FROM ".TABLE_PRODUCTS." LIKE 'products_base_unit_price'";
    $result = $db->Execute($sql);
    if(!$result->RecordCount())
    {
        $sql = "ALTER TABLE ".TABLE_PRODUCTS." ADD products_base_unit_price DECIMAL( 15, 2 ) AFTER products_price";
        $db->Execute($sql);
    }
    
//check if products_base_unit column already exists - if not add it
    $sql ="SHOW COLUMNS FROM ".TABLE_PRODUCTS." LIKE 'products_base_unit'";
    $result = $db->Execute($sql);
    if(!$result->RecordCount())
    {
        $sql = "ALTER TABLE ".TABLE_PRODUCTS." ADD products_base_unit VARCHAR( 12 ) AFTER products_base_unit_price";
        $db->Execute($sql);
    }


$admin_page = 'configGrundpreis';
// delete configuration menu
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
// add configuration menu
if (!zen_page_key_exists($admin_page)) {
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Grundpreisanzeige'
LIMIT 1;");

$db->Execute("INSERT IGNORE INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('configGrundpreis','BOX_CONFIGURATION_GRUNDPREIS','FILENAME_CONFIGURATION',CONCAT('gID=',@gid),'configuration','Y',@gid)");
$messageStack->add('Grundpreisanzeige Konfiguration erfolgreich hinzugefügt.', 'success');  
}