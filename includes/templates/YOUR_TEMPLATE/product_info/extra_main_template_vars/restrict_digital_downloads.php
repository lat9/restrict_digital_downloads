<?php
// -----
// Part of the "Restrict Digital Downloads" plugin by lat9
// Copyright (c) 2014 Vinos de Frutas Tropicales (http://vinosdefrutastropicales.com)
//
// NOTE:  $products_options_names, $options_menu and $order_by are previously set by /includes/modules/attributes.php's processing; $product_is_free is set by
//        //included/modules/pages/{product page}/main_template_vars.php's processing.
//
if (!$product_is_free && isset ($_SESSION['is_restricted_ip']) && isset ($products_options_names)) {
  $products_options_names->Move (0);
  $products_options_names->MoveNext ();  //-Rewind the object to the beginning
  
  $download_selectors = '';
  $downloads_present = false;
  $option_count = 0;
  while (!$products_options_names->EOF) {
    $options_id = (int)$products_options_names->fields['products_options_id'];
    $products_options = $db->Execute ("SELECT pov.products_options_values_id, pov.products_options_values_name, pa.*
                                         from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
                                        where pa.products_id = '" . (int)$_GET['products_id'] . "'
                                          and pa.options_id = '$options_id'
                                          and pa.options_values_id = pov.products_options_values_id
                                          and pov.language_id = '" . (int)$_SESSION['languages_id'] . "' " . $order_by);
    $option_has_download = false;
    while (!$products_options->EOF) {
      $options_values_id = $products_options->fields['options_values_id'];
      $download_check = $db->Execute ("SELECT products_attributes_id FROM " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " WHERE products_attributes_id = " . $products_options->fields['products_attributes_id'] . " LIMIT 1");
      if (!$download_check->EOF) {
        $option_has_download = true;
        $downloads_present = true;
        $products_options_type = zen_get_attributes_type ($products_options->fields['products_attributes_id']);
        switch ($products_options_type) {
          case PRODUCTS_OPTIONS_TYPE_SELECT: {
            $download_selectors .= (($products_options->RecordCount ()) == 1) ? ('#attrib-' . $options_id . '-' . $options_values_id . ', ') : ('#attrib-' . $options_id . ' option[value="' . $options_values_id . '"], ');
            break;
          }
          case PRODUCTS_OPTIONS_TYPE_RADIO: {
            $download_selectors .= '#attrib-' . $options_id . '-' . $options_values_id . ', ';
            break;
          }
          default: {
            break;
          }
        }
      }
      if ($option_has_download && $products_options->RecordCount () == 1 && $products_options_type != PRODUCTS_OPTIONS_TYPE_CHECKBOX) {
        $options_menu[$option_count] .= zen_draw_hidden_field ("download_options[$options_id]", $options_values_id);
        
      }
      $products_options->MoveNext ();
      
    }
    $option_count++;
    $products_options_names->MoveNext ();
    
  }
  if ($downloads_present != '') {
    $messageStack->add ('product_info', PRODUCT_MESSAGE_DOWNLOAD_PRODUCT_RESTRICTED, 'caution');
    
  }
  if ($download_selectors != '') {
    $download_selectors = substr ($download_selectors, 0, -2);  //-Strip trailing ', '
?>
<script type="text/javascript">
$(document).on ('ready', function(){
  $('<?php echo $download_selectors; ?>').each(function(){
    $(this).removeAttr( 'selected checked' );
    $(this).attr( 'disabled', 'disabled' );
  });
});
</script>
<?php
  }
}