<?php
// ---------------------------------------------------------------------------
// Part of the IP2Country support needed for the "Restrict Digital Downloads" plugin
//
// Copyright (C) 2014, Vinos de Frutas Tropicales (lat9)
//
// @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
// ---------------------------------------------------------------------------

require ('includes/application_top.php');

if (!defined('IS_ADMIN_FLAG')) {
  die ('Illegal Access');
}

define ('IP2COUNTRY_BLOCK_SIZE', 1000);
if (isset ($_POST['action'])) {
  if (!(isset ($_FILES['csv_file']) && isset ($_FILES['csv_file']['tmp_name']) && $_FILES['csv_file']['tmp_name'] != '')) {
    $messageStack->add (ERROR_NO_FILE_SPECIFIED);
    
  } else {
    if (!file_exists ($_FILES['csv_file']['tmp_name'])) {
      $messageStack->add (ERROR_FILE_NOT_FOUND);
      
    } else {
      $num_records = 0;
      ini_set ('auto_detect_line_endings', TRUE);
      $handle = fopen ($_FILES['csv_file']['tmp_name'], 'r');
      if ($handle === false) {
        $messageStack->add (ERROR_OPENING_FILE);
        
      } else {
        $db->Execute ("TRUNCATE " . TABLE_IP2COUNTRY);
        $search_string = IP2COUNTRY_RESTRICTED_COUNTRIES . ',-';
        $entry_count = 0;
        $values = '';
        while ( ($data = fgetcsv ($handle) ) !== FALSE ) {
          $num_fields = count ($data);
          if ($num_fields >= 3) {
            if (strpos ($search_string, $data[2]) !== false) {
              $values .= ("( '" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "'), ");
              $entry_count++;
              $num_records++;
              if ($entry_count == IP2COUNTRY_BLOCK_SIZE) {
                $db->Execute ("INSERT INTO " . TABLE_IP2COUNTRY . " (ip_from, ip_to, country_code) VALUES " . substr ($values, 0, -2));
                $entry_count = 0;
                $values = '';
                
              }              
            }            
          }
        }
        if ($values != '') {
          $db->Execute ("INSERT INTO " . TABLE_IP2COUNTRY . " (ip_from, ip_to, country_code) VALUES " . substr ($values, 0, -2));
          
        }
        $messageStack->add_session (sprintf (MESSAGE_NUM_RECORDS, $num_records), 'success');
        fclose ($handle);
        
      }
      ini_set ('auto_detect_line_endings', FALSE);
      
      if ($num_records > 0) {
        $db->Execute ("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . date ('Y-m-d H:i:s') . "' WHERE configuration_key = 'MODULE_IP2COUNTRY_LAST_UPDATE' LIMIT 1");
        zen_redirect (zen_href_link (FILENAME_TOOLS_UPDATE_IP2COUNTRY));
        
      }
    }
  }
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<style type="text/css">
<!--
.buttonLink, .buttonLink:link, .buttonLink:hover, input.buttonLink { 
  background-color:white;
  border:1px solid black;
  color:#404040;
  border-radius:6px;
  display:inline-block;
  font-family:Verdana;
  font-size:11px;
  font-weight:bold;
  margin: 2px;
  padding:3px 8px;
  text-decoration:none; }
a.buttonLink:hover { background-color: #dcdcdc; }
input.submit_button:hover { background-color:#599659; border: 1px solid #003d00; color: white; cursor: pointer; }
input[type=text] { width: 4em; text-align: right;}
input[type=text].model-num { width: 9em; }
input[type=text].date { width: auto; }
.hoverRow:hover { background-color: #dcdcdc; }
.removed, .removed td { text-decoration: line-through; color: #6666ff!important; }
.centered { text-align: center; }
.smaller { font-size: smaller; }
.disabled { color: red; }
-->
</style>
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript">
<!--
function init() {
  cssjsmenu('navbar');
  if (document.getElementById) {
    var kill = document.getElementById('hoverJS');
    kill.disabled = true;
  }
}
// -->
</script>
</head>
<body onload="init();<?php echo (isset ($onload)) ? $onload : ''; ?>">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<?php
$last_updated = MODULE_IP2COUNTRY_LAST_UPDATE;
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE . ' <span class="version">(v' . MODULE_IP2COUNTRY_VERSION . ' &mdash; ' . TEXT_LAST_UPDATED . MODULE_IP2COUNTRY_RELEASE_DATE . ')</span>'; ?></td>
          </tr>
        </table></td>
      </tr>

      <tr>
        <td><?php echo TEXT_IP2L_INSTRUCTIONS; ?></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_form ('choose_csv', FILENAME_TOOLS_UPDATE_IP2COUNTRY, '', 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field ('action', 'update'); ?><table width="100%">
          <tr>
            <td><?php /*<input type="hidden" name="MAX_FILE_SIZE" value="30000" />*/?><?php echo zen_draw_file_field ('csv_file') . '&nbsp;&nbsp;&nbsp;' . zen_image_submit ('button_upload.gif', IMAGE_UPLOAD); ?></td>
          </tr>
        </table></form></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->

  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>