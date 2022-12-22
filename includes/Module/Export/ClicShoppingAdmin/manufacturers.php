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

  $comp = array("Exportation des marques XML");

  $header = 'Content-Type: text/xml';

  $head = '<?xml version="1.0" encoding="UTF-8"?>' . chr(10) . '<manufacturers lang="' . $language_code . '" date="' . date('Y-m-d H:i') . '" GMT="+1" version="2.0">' . chr(10);

  $output .= '<manufacturers place="' . $manufacturers['manufacturers_id'] . '">' . "\n";
  $output .= '<manufacturers_name><![CDATA[' . $manufacturers['manufacturers_name'] . ']]></manufacturers_name>' . chr(10);
  $output .= '<manufacturers_image><![CDATA[' . $manufacturers['manufacturers_image'] . ']]></manufacturers_image>' . chr(10);
  $output .= '<manufacturers_url><![CDATA[' . $manufacturers['manufacturers_url'] . ']]></manufacturers_url>' . chr(10);
  $output .= '</manufacturers>';
  $foot = '</manufacturers>';
?>
