<?php
// ---------------------------------------------------------------------------
// Part of the IP2Country support needed for the "Restrict Digital Downloads" plugin.
//
// Copyright (C) 2014, Vinos de Frutas Tropicales (lat9)
//
// @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
// ---------------------------------------------------------------------------

define ('HEADING_TITLE', 'Update IP2Country Database Table');
define ('TEXT_LAST_UPDATED', 'Last Updated: ');

define ('TEXT_IP2L_INSTRUCTIONS', 'Use this tool to import an IP2Location (www.ip2location.com) .CSV file into your database.  To start, download the most recent copy of IP2LOCATION-LITE-DB1.CSV.ZIP from http://download.ip2location.com/lite/ to your computer and un-zip that file.  Use the &quot;Browse&quot; button to select the unzipped .CSV file and then click the &quot;Update&quot; button to perform the import.<br /><br />This table is used by the <em>Restrict Digital Downloads</em> plugin, provided to you by http://vinosdefrutastropicales.com.  The database was last updated on ' . MODULE_IP2COUNTRY_LAST_UPDATE . '.');

define ('ERROR_NO_FILE_SPECIFIED', 'Please choose a CSV file to be uploaded.');
define ('ERROR_FILE_NOT_FOUND', 'The file you specified was not found, please try again.');
define ('MESSAGE_NUM_RECORDS', 'Processing complete. %u records were added to the ' . TABLE_IP2COUNTRY . ' database table in %u seconds.');