<?php
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '2.8.0' WHERE configuration_key = 'GRUNDPREIS_MODUL_VERSION' LIMIT 1;");