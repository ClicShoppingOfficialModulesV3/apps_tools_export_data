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

  $comp = array("Exportation des clients qui ont aucun compte client pour la newsletter XML");

  $header = 'Content-Type: text/xml';

  $head = '<?xml version="1.0" encoding="UTF-8"?>' . chr(10) . '<newsletter lang="' . $language_code . '" date="' . date('Y-m-d H:i') . '" GMT="+1" version="2.0">' . chr(10);

  $output .= '<newsletter place="' . $product_num . '">' . "\n";

  // Table products
  $output .= '<customers_firstname><![CDATA[' . $newsletter_no_account['customers_firstname'] . ']]></customers_firstname>' . chr(10);
  $output .= '<customers_lastname><![CDATA[' . $newsletter_no_account['customers_lastname'] . ']]></customers_lastname>' . chr(10);
  $output .= '<customers_email_address><![CDATA[' . $newsletter_no_account['customers_email_address'] . ']]></customers_email_address>' . chr(10);
  $output .= '</newsletter>';
  $foot = '</newsletter>';
?>
