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

  $comp = array("Exportation des clients XML");

  $header = 'Content-Type: text/xml';

  $head = '<?xml version="1.0" encoding="UTF-8"?>' . chr(10) . '<customers lang="' . $language_code . '" date="' . date('Y-m-d H:i') . '" GMT="+1" version="2.0">' . chr(10);

  $output .= '<customers place="' . $customers['customers_id'] . '">' . "\n";
  // Table customers
  $output .= '<customers_company><![CDATA[' . $customers['customers_company'] . ']]></customers_company>' . chr(10);
  $output .= '<customers_siret><![CDATA[' . $customers['customers_siret'] . ']]></customers_siret>' . chr(10);
  $output .= '<customers_ape><![CDATA[' . $customers['customers_ape'] . ']]></customers_ape>' . chr(10);
  $output .= '<customers_tva_intracom><![CDATA[' . $customers['customers_tva_intracom'] . ']]></customers_tva_intracom>' . chr(10);
  $output .= '<customers_tva_intracom_code_iso><![CDATA[' . $customers['customers_tva_intracom_code_iso'] . ']]></customers_tva_intracom_code_iso>' . chr(10);
  $output .= '<customers_gender><![CDATA[' . $customers['customers_gender'] . ']]></customers_gender>' . chr(10);
  $output .= '<customers_firstname><![CDATA[' . $customers['customers_firstname'] . ']]></customers_firstname>' . chr(10);
  $output .= '<customers_lastname><![CDATA[' . $customers['customers_lastname'] . ']]></customers_lastname>' . chr(10);
  $output .= '<customers_dob><![CDATA[' . $customers['customers_dob'] . ']]></customers_dob>' . chr(10);
  $output .= '<customers_email_address><![CDATA[' . $customers['customers_email_address'] . ']]></customers_email_address>' . chr(10);
  $output .= '<customers_default_address_id><![CDATA[' . $customers['customers_default_address_id'] . ']]></customers_default_address_id>' . chr(10);
  $output .= '<customers_telephone><![CDATA[' . $customers['customers_telephone'] . ']]></customers_telephone>' . chr(10);
  $output .= '<customers_fax><![CDATA[' . $customers['customers_fax'] . ']]></customers_fax>' . chr(10);
  $output .= '<customers_password><![CDATA[' . $customers['customers_password'] . ']]></customers_password>' . chr(10);
  $output .= '<customers_newsletter><![CDATA[' . $customers['customers_newsletter'] . ']]></customers_newsletter>' . chr(10);
  $output .= '<customers_newsletter_languages_code><![CDATA[' . $customers['customers_newsletter_languages_code'] . ']]></customers_newsletter_languages_code>' . chr(10);
  $output .= '<customers_group_id><![CDATA[' . $customers['customers_group_id'] . ']]></customers_group_id>' . chr(10);
  $output .= '<member_level><![CDATA[' . $customers['member_level'] . ']]></member_level>' . chr(10);
  $output .= '<customers_options_order_taxe><![CDATA[' . $customers['customers_options_order_taxe'] . ']]></customers_options_order_taxe>' . chr(10);
  $output .= '<customers_modify_company><![CDATA[' . $customers['customers_modify_company'] . ']]></customers_modify_company>' . chr(10);
  $output .= '<customers_modify_address_default><![CDATA[' . $customers['customers_modify_address_default'] . ']]></customers_modify_address_default>' . chr(10);
  $output .= '<customers_add_address><![CDATA[' . $customers['customers_add_address'] . ']]></customers_add_address>' . chr(10);

  // table adress book
  $output .= '<entry_company><![CDATA[' . $customers['entry_company'] . ']]></entry_company>' . chr(10);
  $output .= '<entry_street_address><![CDATA[' . $customers['entry_street_address'] . ']]></entry_street_address>' . chr(10);
  $output .= '<entry_suburb><![CDATA[' . $customers['entry_suburb'] . ']]></entry_suburb>' . chr(10);
  $output .= '<entry_postcode><![CDATA[' . $customers['entry_postcode'] . ']]></entry_postcode>' . chr(10);
  $output .= '<entry_city><![CDATA[' . $customers['entry_city'] . ']]></entry_city>' . chr(10);
  $output .= '<entry_state><![CDATA[' . $customers['entry_state'] . ']]></entry_state>' . chr(10);
  $output .= '<entry_country_id><![CDATA[' . $customers['entry_country_id'] . ']]></entry_country_id>' . chr(10);
  $output .= '<entry_zone_id><![CDATA[' . $customers['entry_zone_id'] . ']]></entry_zone_id>' . chr(10);
  $output .= '<customers_default_address_id><![CDATA[' . $customers['customers_default_address_id'] . ']]></customers_default_address_id>' . chr(10);
  $output .= '</customers>';
  $foot = '</customers>';
?>
