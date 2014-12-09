<?php
// -----
// Part of the "Restrict Digital Downloads" plugin by Cindy Merkin (cindy@vinosdefrutastropicales.com)
// Copyright (c) 2014 Vinos de Frutas Tropicales
//
if (isset ($_SESSION['is_restricted_ip']) && isset ($products_options)) {
  $products_options->Move (0);
  $products_options->MoveNext ();  //-Rewind the object to the beginning
  
  $download_selectors = '';
  while (!$products_options->EOF) {
    $download_check = $db->Execute ("SELECT products_attributes_id FROM " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " WHERE products_attributes_id = " . $products_options->fields['products_attributes_id'] . " LIMIT 1");
    if (!$download_check->EOF) {
      switch (zen_get_attributes_type ($products_options->fields['products_attributes_id'])) {
        case PRODUCTS_OPTIONS_TYPE_SELECT: {
          $download_selectors .= '#attrib-' . $products_options->fields['options_id'] . ' option[value="' . $products_options->fields['options_values_id'] . '"], ';
          break;
        }
        case PRODUCTS_OPTIONS_TYPE_RADIO:    //-fall-through
        case PRODUCTS_OPTIONS_TYPE_CHECKBOX: {
          $download_selectors .= '#attrib-' . $products_options->fields['options_id'] . '-' . $products_options->fields['options_values_id'] . ', ';
          break;
        }
        default: {
          break;
        }
      }
    }
    $products_options->MoveNext ();
    
  }
  if ($download_selectors != '') {
    $messageStack->add ('product_info', PRODUCT_MESSAGE_DOWNLOAD_PRODUCT_RESTRICTED, 'caution');
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