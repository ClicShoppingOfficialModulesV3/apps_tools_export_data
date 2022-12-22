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

  namespace ClicShopping\Apps\Tools\ExportData\Sites\ClicShoppingAdmin\Pages\Home\Actions;

  use ClicShopping\OM\Registry;

  class ExportDb extends \ClicShopping\OM\PagesActionsAbstract
  {

    public function execute()
    {
      $CLICSHOPPING_ExportData = Registry::get('ExportData');

      $this->page->setUseSiteTemplate(false); //don't display Header / Footer
      $this->page->setFile('export_db.php');
    }


    public function netoyage_html($CatList, $length)
    {
      $CatList = html_entity_decode($CatList);
      $CatList = strip_tags($CatList);
      $CatList = trim($CatList);
      $CatList = strtolower($CatList);
      $CatList = str_replace(chr(9), "", $CatList);
      $CatList = str_replace(chr(10), "", $CatList);
      $CatList = str_replace(chr(13), "", $CatList);
      $CatList = str_replace('&nbsp;', ' ', $CatList);
      $CatList = preg_replace("[<(.*?)>]", "", $CatList);

      if (strlen($CatList) > $length) {
        $CatList = substr($CatList, 0, $length - 3) . "...";
      }
      return $CatList;
    }
  }