<?php
// -----
// Part of the IP2Country support needed for the "Restrict Digital Downloads" plugin by Cindy Merkin (cindy@vinosdefrutastropicales.com)
// Copyright (c) 2014 Vinos de Frutas Tropicales
//
define ('TABLE_IP2COUNTRY', DB_PREFIX . 'ip2country');
define ('FILENAME_TOOLS_UPDATE_IP2COUNTRY', 'tools_update_ip2country');

// -----
// Edit this list (packed, comma-separated) to identify the countries to be restricted from receiving automatic digital downloads from your store.
//
define ('IP2COUNTRY_RESTRICTED_COUNTRIES', 'AT,BE,BG,HR,CY,CZ,DK,EE,FI,FR,DE,GR,HU,IE,IT,LV,LT,LU,MT,NL,PL,PT,RO,SK,SI,ES,SE,GB');