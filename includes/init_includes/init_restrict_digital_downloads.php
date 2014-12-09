<?php
// -----
// Part of the "Digital Download Restrictions" plugin by Cindy Merkin (cindy@vinosdefrutastropicales.com)
// Copyright (c) 2014 Vinos de Frutas Tropicales
//

function is_digital_download ($products_id, $options_id, $options_value_id) {
  global $db;
  
  $sql = "SELECT pa.products_id FROM " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
          WHERE pa.products_id = " . (int)$products_id . "
            AND   pa.options_id = " . (int)$options_id . "
            AND   pa.options_values_id = " . (int)$options_value_id . "
            AND   pa.products_attributes_id = pad.products_attributes_id LIMIT 1";
  $sql_result = $db->Execute($sql);

  return ($sql_result->EOF) ? false : true;
  
}

if (!isset ($_SESSION['is_restricted_ip'])) {
  $ipv4_address_check = filter_var ($customers_ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
  if ($ipv4_address_check === false) {
    $is_restricted_ip = true;
    
  } else {
    $ipv4_quads = explode ('.', $customers_ip_address);
    $ipv4_integer = $ipv4_quads[3] + $ipv4_quads[2] * 256 + $ipv4_quads[1] * 256 * 256 + $ipv4_quads[0] * 256 * 256 * 256;
    
    $ipv4_check = $db->Execute ("SELECT * FROM " . TABLE_IP2COUNTRY . " WHERE ip_from <= $ipv4_integer AND ip_to >= $ipv4_integer LIMIT 1");
    $is_restricted_ip = !($ipv4_check->EOF);
  }
  $_SESSION['is_restricted_ip'] = $is_restricted_ip;
  
}