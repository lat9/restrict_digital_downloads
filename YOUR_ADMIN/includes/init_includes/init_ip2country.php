<?php
// ---------------------------------------------------------------------------
// Part of the Restrict Digital Downloads plugin for Zen Cart v1.5.0 and later
//
// Copyright (C) 2014-2015, Vinos de Frutas Tropicales (lat9)
//
// @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
// ---------------------------------------------------------------------------

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

define('IP2COUNTRY_CURRENT_VERSION', '1.1.0');
define('IP2COUNTRY_UPDATE_DATE', '2015-04-06');

function init_i2l_next_sort($menu_key) {
  global $db;
  $next_sort = $db->Execute('SELECT MAX(sort_order) as max_sort FROM ' . TABLE_ADMIN_PAGES . " WHERE menu_key='$menu_key'");
  return $next_sort->fields['max_sort'] + 1;
}
//----
// Create the database table that holds the EU-based IP address ranges
//
$sql = "CREATE TABLE IF NOT EXISTS " . TABLE_IP2COUNTRY . " (
  ip_from int(11) unsigned NOT NULL,
  ip_to int(11) unsigned NOT NULL,
  country_code char(2) NOT NULL,
  PRIMARY KEY(ip_from, ip_to)
)";
$db->Execute($sql);

// -----
// Add some (hidden) configuration values to identify the module's version and the last time the IP2LOCATION input file was converted.
//
if (!defined('MODULE_IP2COUNTRY_VERSION')) {  
  $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('IP2COUNTRY: Version', 'MODULE_IP2COUNTRY_VERSION', '" . IP2COUNTRY_CURRENT_VERSION . "', 'The IP2COUNTRY plugin version number', '6', '100', now())");
  $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('IP2COUNTRY: Release Date', 'MODULE_IP2COUNTRY_RELEASE_DATE', '" . IP2COUNTRY_UPDATE_DATE . "', 'The IP2COUNTRY plugin release date', '6', '101', now())");
  $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('IP2COUNTRY: Database Update', 'MODULE_IP2COUNTRY_LAST_UPDATE', '0001-01-01 00:00:00', 'The IP2COUNTRY last database update date', '6', '102', now())");
  
  define ('MODULE_IP2COUNTRY_VERSION', IP2COUNTRY_CURRENT_VERSION);
  define ('MODULE_IP2COUNTRY_RELEASE_DATE', IP2COUNTRY_UPDATE_DATE);

}

// -----
// Update the configuration table to reflect the current version, if it's not already set.
//
if (MODULE_IP2COUNTRY_VERSION != IP2COUNTRY_CURRENT_VERSION) {
  $db->Execute ("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . IP2COUNTRY_CURRENT_VERSION . "' WHERE configuration_key = 'MODULE_IP2COUNTRY_VERSION'");
  $db->Execute ("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . IP2COUNTRY_UPDATE_DATE . "' WHERE configuration_key = 'MODULE_IP2COUNTRY_RELEASE_DATE'");
  
}

if (!zen_page_key_exists ('toolsUpdateIP2Country')) {
  zen_register_admin_page('toolsUpdateIP2Country', 'BOX_TOOLS_UPDATE_IP2COUNTRY', 'FILENAME_TOOLS_UPDATE_IP2COUNTRY', '', 'tools', 'Y', init_i2l_next_sort ('tools'));
  
}