<?php
// -----
// Part of the "Restrict Digital Downloads" plugin by Cindy Merkin (cindy@vinosdefrutastropicales.com)
// Copyright (c) 2014 Vinos de Frutas Tropicales
//
switch ($_GET['action']) {
  /*----
  ** If a product is being added to the cart and that product includes attributes (the $_POST['id'] array
  ** is set), then check each of the attributes being added to see if there is a download/virtual product amongst them.  If so,
  ** don't allow the duplicate download/virtual product to be added to the cart ... or just add 1 if this is the original add.
  */
  case 'add_product': {
    if ($_SESSION['is_restricted_ip'] && isset($_POST['products_id']) && $_POST['cart_quantity'] > 0) {
      $the_options = array ();
      if (isset($_POST['id']) && is_array($_POST['id'])) {
        $the_options = $_POST['id'];
        
      }
      if (isset ($_POST['download_options']) && is_array ($_POST['download_options'])) {
        foreach ($_POST['download_options'] as $option => $value) {
          if (!isset ($the_options[$option])) {
            $the_options[$option] = $value;
            
          }
        }
      }
      foreach ($the_options as $option => $value) {
        if (is_digital_download ($_POST['products_id'], $option, $value)) {
          $messageStack->add ('header', sprintf (CART_MESSAGE_DOWNLOAD_PRODUCT_RESTRICTED, zen_get_products_name ($_POST['products_id'])), 'caution');
          unset ($_GET['action']);
          break;

        }
      }
    }
    break;
  }
}
