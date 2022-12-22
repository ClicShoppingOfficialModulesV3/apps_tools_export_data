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

  defined('E_DEPRECATED') ? error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE);

  $comp = array("Exportation des fournisseurs XML");

  $header = 'Content-Type: text/xml';

  $head = '<?xml version="1.0" encoding="UTF-8"?>' . chr(10) . '<suppliers lang="' . $language_code . '" date="' . date('Y-m-d H:i') . '" GMT="+1" version="2.0">' . chr(10);

  $output .= '<suppliers place="' . $suppliers['suppliers_id'] . '">' . "\n";
  $output .= '<suppliers_name><![CDATA[' . $suppliers['suppliers_name'] . ']]></suppliers_name>' . chr(10);
  $output .= '<suppliers_image><![CDATA[' . $suppliers['suppliers_image'] . ']]></suppliers_image>' . chr(10);
  $output .= '<suppliers_manager><![CDATA[' . $suppliers['suppliers_manager'] . ']]></suppliers_manager>' . chr(10);
  $output .= '<suppliers_phone>' . $suppliers['suppliers_phone'] . '</suppliers_phone>' . chr(10);
  $output .= '<suppliers_email_address><![CDATA[' . $suppliers['suppliers_email_address'] . ']]></suppliers_email_address>' . chr(10);
  $output .= '<suppliers_fax>' . $suppliers['suppliers_fax'] . '</suppliers_fax>' . chr(10);
  $output .= '<suppliers_address><![CDATA[' . $suppliers['suppliers_address'] . ']]></suppliers_address>' . chr(10);
  $output .= '<suppliers_suburb><![CDATA[' . $suppliers['suppliers_suburb'] . ']]></suppliers_suburb>' . chr(10);
  $output .= '<suppliers_email_address><![CDATA[' . $suppliers['suppliers_email_address'] . ']]></suppliers_email_address>' . chr(10);
  $output .= '<suppliers_postcode>' . $suppliers['suppliers_postcode'] . '</suppliers_postcode>' . chr(10);
  $output .= '<suppliers_city><![CDATA[' . $suppliers['suppliers_city'] . ']]></suppliers_city>' . chr(10);
  $output .= '<suppliers_states>' . $suppliers['suppliers_states'] . '</suppliers_states>' . chr(10);
  $output .= '<suppliers_country_id>' . $suppliers['suppliers_country_id'] . '</suppliers_country_id>' . chr(10);
  $output .= '<suppliers_notes><![CDATA[' . $suppliers['suppliers_notes'] . ']]></suppliers_notes>' . chr(10);
  $output .= '<suppliers_url><![CDATA[' . $suppliers['suppliers_url'] . ']]></suppliers_url>' . chr(10);
  $output .= '</suppliers>';
  $foot = '</suppliers>';
?>
