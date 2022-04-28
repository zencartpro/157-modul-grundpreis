<?php
//check if products_unit_pricing_measure column already exists - if not add it
    $sql ="SHOW COLUMNS FROM ".TABLE_PRODUCTS." LIKE 'products_unit_pricing_measure'";
    $result = $db->Execute($sql);
    if(!$result->RecordCount())
    {
        $sql = "ALTER TABLE ".TABLE_PRODUCTS." ADD products_unit_pricing_measure VARCHAR( 12 ) AFTER products_base_unit";
        $db->Execute($sql);
    }
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '2.9.0' WHERE configuration_key = 'GRUNDPREIS_MODUL_VERSION' LIMIT 1;");