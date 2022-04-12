<?php
/**
 * @package Grundpreis
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: functions_base_unit_price.php 2022-04-12 09:56:51Z webchills $
 */
 
////
// computes products_price + option groups lowest attributes price of each group when on
  function zen_get_products_base_unit_price($products_id) {
    global $db, $currencies;

    $product_check = $db->Execute("select products_price, products_base_unit_price, products_base_unit from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");

    // is there a products_price to add to attributes
    $products_base_unit_price = $product_check->fields['products_base_unit_price'];

    // do not select display only attributes and attributes_price_base_included is true
    $product_att_query = $db->Execute("select options_id, price_prefix, options_values_price, attributes_display_only, attributes_price_base_included from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "' and attributes_display_only != '1' and attributes_price_base_included='1'". " order by options_id, price_prefix, options_values_price");

    $the_options_id= 'x';
    $the_base_price= 0;

    return $currencies->format(zen_round($products_base_unit_price, 3)).'/'.$product_check->fields['products_base_unit'];
  }