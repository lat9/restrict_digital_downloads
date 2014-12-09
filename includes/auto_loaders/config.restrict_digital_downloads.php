<?php
// -----
// Part of the "Restrict Digital Downloads" plugin by Cindy Merkin (cindy@vinosdefrutastropicales.com)
// Copyright (c) 2014 Vinos de Frutas Tropicales
//
if (!defined('IS_ADMIN_FLAG')) {
 die('Illegal Access');
}

$autoLoadConfig[135][] = array ('autoType' => 'init_script',
                                'loadFile' => 'init_restrict_digital_downloads.php');