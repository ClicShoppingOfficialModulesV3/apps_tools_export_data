<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  $comp = array("Exportation des relations produits XML");

  $products_description = $products['products_description'];
  $products_description = html_entity_decode($products_description);

  $header = 'Content-Type: text/xml';

  $head = '<?xml version="1.0" encoding="UTF-8"?>' . chr(10) . '<products lang="' . $language_code . '" date="' . date('Y-m-d H:i') . '" GMT="+1" version="2.0">' . chr(10);

  $output .= '<product place="' . $products['products_id'] . '">' . "\n";

  // Table products
  $output .= '<products_quantity>' . $products['products_quantity'] . '</products_quantity>' . chr(10);
  $output .= '<products_model><![CDATA[' . $products['products_model'] . ']]></products_model>' . chr(10);
  $output .= '<products_ean>' . $products['products_ean'] . '</products_ean>' . chr(10);
  $output .= '<products_sku>' . $products['products_sku'] . '</products_sku>' . chr(10);
  $output .= '<products_image><![CDATA[' . $products['products_image'] . ']]></products_image>' . chr(10);
  $output .= '<products_image_zoom><![CDATA[' . $products['products_image_zoom'] . ']]></products_image_zoom>' . chr(10);
  $output .= '<products_price><![CDATA[' . $products['products_price'] . ']]></products_price>' . chr(10);
  $output .= '<products_date_added>' . $products['products_date_added'] . '</products_date_added>' . chr(10);
  $output .= '<products_last_modified>' . $products['products_last_modified'] . '</products_last_modified>' . chr(10);
  $output .= '<products_weight>' . $products['products_weight'] . '</products_weight>' . chr(10);
  $output .= '<products_price_kilo>' . $products['products_price_kilo'] . '</products_price_kilo>' . chr(10);
  $output .= '<products_status>' . $products['products_status'] . '</products_status>' . chr(10);
  $output .= '<products_tax_class_id>' . $products['products_tax_class_id'] . '</products_tax_class_id>' . chr(10);
  $output .= '<manufacturers_id>' . $products['manufacturers_id'] . '</manufacturers_id>' . chr(10);
  $output .= '<products_ordered>' . $products['products_ordered'] . '</products_ordered>' . chr(10);
  $output .= '<products_percentage><![CDATA[' . $products['products_percentage'] . ']]></products_percentage>' . chr(10);
  $output .= '<products_view>' . $products['products_view'] . '</products_view>' . chr(10);
  $output .= '<orders_view>' . $products['orders_view'] . '</orders_view>' . chr(10);
  $output .= '<suppliers_id>' . $products['suppliers_id'] . '</suppliers_id>' . chr(10);
  $output .= '<products_archive>' . $products['products_archive'] . '</products_archive>' . chr(10);
  $output .= '<products_min_qty_order>' . $products['products_min_qty_order'] . '</products_min_qty_order>' . chr(10);
  $output .= '<products_price_comparison>' . $products['products_price_comparison'] . '</products_price_comparison>' . chr(10);
  $output .= '<products_dimension_width>' . $products['products_dimension_width'] . '</products_dimension_width>' . chr(10);
  $output .= '<products_dimension_height>' . $products['products_dimension_height'] . '</products_dimension_height>' . chr(10);
  $output .= '<products_dimension_depth>' . $products['products_dimension_depth'] . '</products_dimension_depth>' . chr(10);
  $output .= '<products_dimension_type>' . $products['products_dimension_type'] . '</products_dimension_type>' . chr(10);

  // table description
  $output .= '<language_id><![CDATA[' . $products['language_id'] . ']]></language_id>' . chr(10);
  $output .= '<products_name><![CDATA[' . $products['products_name'] . ']]></products_name>' . chr(10);
  $output .= '<products_description><![CDATA[' . $products_description . '...]]></products_description>' . chr(10);
  $output .= '<products_url><![CDATA[' . $products['products_url'] . ']]></products_url>' . chr(10);
  $output .= '<products_viewed><![CDATA[' . $products['products_viewed'] . ']]></products_viewed>' . chr(10);
  $output .= '<products_head_title_tag><![CDATA[' . $products['products_head_title_tag'] . ']]></products_head_title_tag>' . chr(10);
  $output .= '<products_head_desc_tag><![CDATA[' . $products['products_head_desc_tag'] . ']]></products_head_desc_tag>' . chr(10);
  $output .= '<products_head_keywords_tag><![CDATA[' . $products['products_head_keywords_tag'] . ']]></products_head_keywords_tag>' . chr(10);

  // Table manufacturers
  $output .= '<manufacturers_name><![CDATA[' . $products['manufacturers_name'] . ']]></manufacturers_name>' . chr(10);
  $output .= '<manufacturers_image><![CDATA[' . $products['manufacturers_image'] . ']]></manufacturers_image>' . chr(10);
  $output .= '<manufacturers_url><![CDATA[' . $products['manufacturers_url'] . ']]></manufacturers_url>' . chr(10);

  // Table suppliers
  $output .= '<suppliers_name><![CDATA[' . $products['suppliers_name'] . ']]></suppliers_name>' . chr(10);
  $output .= '<suppliers_image><![CDATA[' . $products['suppliers_image'] . ']]></suppliers_image>' . chr(10);
  $output .= '<suppliers_manager><![CDATA[' . $products['suppliers_manager'] . ']]></suppliers_manager>' . chr(10);
  $output .= '<suppliers_phone>' . $products['suppliers_phone'] . '</suppliers_phone>' . chr(10);
  $output .= '<suppliers_email_address><![CDATA[' . $products['suppliers_email_address'] . ']]></suppliers_email_address>' . chr(10);
  $output .= '<suppliers_fax>' . $products['suppliers_fax'] . '</suppliers_fax>' . chr(10);
  $output .= '<suppliers_address><![CDATA[' . $products['suppliers_address'] . ']]></suppliers_address>' . chr(10);
  $output .= '<suppliers_suburb><![CDATA[' . $products['suppliers_suburb'] . ']]></suppliers_suburb>' . chr(10);
  $output .= '<suppliers_email_address><![CDATA[' . $products['suppliers_email_address'] . ']]></suppliers_email_address>' . chr(10);
  $output .= '<suppliers_postcode>' . $products['suppliers_postcode'] . '</suppliers_postcode>' . chr(10);
  $output .= '<suppliers_city><![CDATA[' . $products['suppliers_city'] . ']]></suppliers_city>' . chr(10);
  $output .= '<suppliers_states>' . $products['suppliers_states'] . '</suppliers_states>' . chr(10);
  $output .= '<suppliers_country_id>' . $products['suppliers_country_id'] . '</suppliers_country_id>' . chr(10);
  $output .= '<suppliers_notes><![CDATA[' . $products['suppliers_notes'] . ']]></suppliers_notes>' . chr(10);
  $output .= '<suppliers_url><![CDATA[' . $products['suppliers_url'] . ']]></suppliers_url>' . chr(10);
  $output .= '</product>';
  $foot = '</products>';
?>
