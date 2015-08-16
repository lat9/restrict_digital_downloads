<?php
// ---------------------------------------------------------------------------
// Part of the IP2Country support needed for the "Restrict Digital Downloads" plugin.
//
// Copyright (C) 2014-2015, Vinos de Frutas Tropicales (lat9)
//
// @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
// ---------------------------------------------------------------------------

define ('HEADING_TITLE', 'Update IP2Country Database Table');
define ('TEXT_LAST_UPDATED', 'Last Updated: ');

define ('TEXT_IP2L_INSTRUCTIONS', 'Use this tool to import an IP2Location (www.ip2location.com) .CSV file into your database.  To start, download the most recent copy of IP2LOCATION-LITE-DB1.CSV.ZIP from http://download.ip2location.com/lite/ to your computer and un-zip that file.<br /><br />There are IP address ranges within the zip-file that were &quot;unassigned&quot; at the time the zip-file was created.  To restrict these addresses, too, tick the checkbox below. Use the &quot;Browse&quot; button to select the unzipped .CSV file and then click the &quot;upload&quot; button to perform the import.<br /><br />This table is used by the <em>Restrict Digital Downloads</em> plugin, provided to you by http://vinosdefrutastropicales.com.  The database was last updated on ' . MODULE_IP2COUNTRY_LAST_UPDATE . '; unassigned IP address blocks are %s restricted.');  //-%s contains either '' or 'not'

define ('LABEL_RESTRICT_UNASSIGNED', 'Restrict &quot;Unassigned&quot; IP-address ranges? ');
define ('ERROR_NO_FILE_SPECIFIED', 'Please choose a CSV file to be uploaded.');
define ('ERROR_FILE_NOT_FOUND', 'The file you specified was not found, please try again.');
define ('MESSAGE_NUM_RECORDS', 'Processing complete. %u records were added to the ' . TABLE_IP2COUNTRY . ' database table.'); 

define ('TEXT_IP_ADDRESS_INSTRUCTIONS', 'Once you\'ve imported the database, use the form below to see if a specific IPv4 address will be restricted.');
define ('LABEL_IP_ADDRESS', 'IP Address: ');
define ('ERROR_INVALID_IP_ADDRESS', 'The IP Address you entered is not valid, please re-enter the value.');
define ('MESSAGE_IP_ADDRESS_STATUS', 'The IP Address you entered (%1$s, %2$s) is %3$s restricted.');  //-%1$s is the IP Address, %2$s is its numeric value, %3$s contains either '' or the following
define ('MESSAGE_IP_ADDRESS_NOT_RESTRICTED', '<b>not</b>');
