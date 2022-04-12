####################################################################################
# Grundpreisanzeige UNINSTALL - 2019-07-13 - webchills
# Nur ausführen, wenn Sie das Modul vollständig aus der Datenbank entfernen wollen!
# !!!!! SIE LÖSCHEN DAMIT AUCH ALLE HINTERLEGTEN GRUNDPREISE !!!!!
####################################################################################

ALTER TABLE products DROP COLUMN products_base_unit_price;
ALTER TABLE products DROP COLUMN products_base_unit;
DELETE FROM configuration WHERE configuration_key LIKE '%SHOW_BASE_UNIT_PRICE%';
DELETE FROM configuration WHERE configuration_key LIKE '%GRUNDPREIS_MODUL_VERSION%';
DELETE FROM configuration_language WHERE configuration_key LIKE '%SHOW_BASE_UNIT_PRICE%';
DELETE FROM admin_pages WHERE page_key='configGrundpreis';