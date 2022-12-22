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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTTP;

  defined('E_DEPRECATED') ? error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE);

  $CLICSHOPPING_ExportData = Registry::get('ExportData');
  $CLICSHOPPING_Language = Registry::get('Language');
  $CLICSHOPPING_Db = Registry::get('Db');
// temps d'execution infini
// ne fonctionne pas sur tous les serveurs, dans ce cas il y aura des timeouts
// et les fichiers seront incomplets. Mieux vaut alors opter pour un hebergement plus performant.


  $output = '';

// securisation des variables et verification
//La ligne ci-apres permet de passer des frais de port fixe dans l'url
//$port = (isset($_GET['port']) && !is_null($_GET['port'])) ? HTML::sanitize($_GET['port']) : "-1";
  $verif = true;
  $pass = EXPORT_CODE;
  $language_code = (isset($_GET['language']) && !is_null($_GET['language'])) ? HTML::sanitize($_GET['language']) : DEFAULT_LANGUAGE;

  if (isset($_GET['p'])) $p = HTML::sanitize($_GET['p']);
  if (isset($_GET['format'])) $format = basename(HTML::sanitize($_GET['format']));
  if (isset($_GET['cache'])) if (isset($_GET['p'])) $cache = HTML::sanitize($_GET['cache']);
  if (isset($_GET['fichier'])) $fichier = HTML::sanitize($_GET['fichier']);
  if (isset($_GET['libre'])) $libre = HTML::sanitize($_GET['libre']);

  $rep = '../ext/export/';

//On verifie le code avant de lancer les requetes
  if (($verif === true && $p == $pass) || $verif === false) {

//  ------------------------------------------ //
//  -- Categories with languague             -- //
//  ------------------------------------------ //
    $inc_cat = [];

    $QincludedCategories = $CLICSHOPPING_ExportData->db->prepare('select c.categories_id,
                                                                        c.parent_id,
                                                                        cd.categories_name
                                                                 from :table_categories c,
                                                                      :table_categories_description cd
                                                                 where c.categories_id = cd.categories_id
                                                                 and cd.language_id = :language_id
                                                                ');
    $QincludedCategories->bindInt(':language_id', $CLICSHOPPING_Language->getId());
    $QincludedCategories->execute();

// Identification du nom de la categorie, et l'id de la categorie parent
    while ($QincludedCategories->fetch()) {

      $inc_cat[] = ['id' => $QincludedCategories->valueInt('categories_id'),
        'parent' => $QincludedCategories->valueInt('parent_id'),
        'name' => $QincludedCategories->value('categories_name')
      ];
    }

    $cat_info = [];
    for ($i = 0; $i < count($inc_cat); $i++)

      $cat_info[$inc_cat[$i]['id']] = array('parent' => $inc_cat[$i]['parent'],
        'name' => $inc_cat[$i]['name'],
        'path' => $inc_cat[$i]['id'],
        'link' => '');

    for ($i = 0; $i < count($inc_cat); $i++) {
      $cat_id = $inc_cat[$i]['id'];

      while ($cat_info[$cat_id]['parent'] != 0) {
        $cat_info[$inc_cat[$i]['id']]['path'] = $cat_info[$cat_id]['parent'] . '_' . $cat_info[$inc_cat[$i]['id']]['path'];
        $cat_id = $cat_info[$cat_id]['parent'];
      }

      $link_array = preg_split('#_#', $cat_info[$inc_cat[$i]['id']] ['path']);

      for ($j = 0; $j < count($link_array); $j++) {
        $cat_info[$inc_cat[$i]['id']]['link'] .= '&nbsp;<a href="' . CLICSHOPPING::link('Shop/' . CLICSHOPPING::getConfig('bootstrap_file'), 'cPath=' . $cat_info[$link_array[$j]]['path']) . '"><nobr>' . $cat_info[$link_array[$j]]['name'] . '</nobr></a>&nbsp;&raquo;&nbsp;';
      }
    }


//  -------------------------------------------- //
//  -- products with language                 -- //
//  -------------------------------------------- //
    $product_num = 0;

    if ($format == 'product_all.php') {
      // Requete identifiant les produits disponibles dans le catalogue

      $Qproducts = $CLICSHOPPING_ExportData->db->prepare('select p.*,
                                                           pd.*,
                                                           pc.categories_id
                                                    from  :table_products p,
                                                          :table_products_description pd,
                                                          :table_products_to_categories pc
                                                    where p.products_id = pd.products_id
                                                    and p.products_id = pc.products_id
                                                    and pd.language_id = :language_id
                                                    order by p.products_id
                                                   ');
      $Qproducts->bindInt(':language_id', $CLICSHOPPING_Language->getId());
      $Qproducts->execute();

      while ($products = $Qproducts->fetch()) {

        if (intval($products['manufacturers_id']) > 0) {

          $Qmanufacturers = $CLICSHOPPING_ExportData->db->prepare('select m.*,
                                                                 mi.*
                                                           from :table_manufacturers  m,
                                                                :table_manufacturers_info mi
                                                           where m.manufacturers_id = :manufacturers_id
                                                           and mi.manufacturers_id = m.manufacturers_id
                                                          ');
          $Qmanufacturers->bindInt(':manufacturers_id', (int)$products['manufacturers_id']);
          $Qmanufacturers->execute();

          $manufacturers_result = $Qmanufacturers->fetch();

          $products['manufacturers_name'] = $manufacturers_result['manufacturers_name'];
          $products['manufacturers_image'] = $manufacturers_result['manufacturers_image'];
          $products['manufacturers_url'] = $manufacturers_result['manufacturers_url'];
        }

        if (intval($products['suppliers_id']) > 0) {

          $Qsuppliers = $CLICSHOPPING_ExportData->db->prepare('select s.*,
                                                             si.*
                                                       from :table_suppliers s,
                                                            :table_suppliers_info si
                                                       where s.suppliers_id = :suppliers_id
                                                       and si.suppliers_id = s.suppliers_id
                                                      ');
          $Qsuppliers->bindInt(':suppliers_id', (int)$products['suppliers_id']);
          $Qsuppliers->execute();

          $suppliers_result = $Qsuppliers->fetch();

          $products['suppliers_name'] = $suppliers_result['suppliers_name'];
          $products['suppliers_image'] = $manufacturers_result['suppliers_image'];
          $products['suppliers_url'] = $manufacturers_result['suppliers_url'];
          $products['suppliers_manager'] = $suppliers_result['suppliers_manager'];
          $products['suppliers_phone'] = $suppliers_result['suppliers_phone'];
          $products['suppliers_email_address'] = $suppliers_result['suppliers_email_address'];
          $products['suppliers_fax'] = $suppliers_result['suppliers_fax'];
          $products['suppliers_address'] = $suppliers_result['suppliers_address'];
          $products['suppliers_suburb'] = $suppliers_result['suppliers_suburb'];
          $products['suppliers_email_address'] = $suppliers_result['suppliers_email_address'];
          $products['suppliers_postcode'] = $suppliers_result['suppliers_postcode'];
          $products['suppliers_city'] = $suppliers_result['suppliers_city'];
          $products['suppliers_states'] = $suppliers_result['suppliers_states'];
          $products['suppliers_country_id'] = $suppliers_result['suppliers_country_id'];
          $products['suppliers_notes'] = $suppliers_result['suppliers_notes'];
        }

        $product_num++;

        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }
    } elseif ($format == 'product.php') {

      $Qproducts = $CLICSHOPPING_Db->prepare('select p.*,
                                             pd.*,
                                             pc.categories_id
                                      from  :table_products p,
                                            :table_products_description pd,
                                            :table_products_to_categories pc
                                     where p.products_id = pd.products_id
                                     and p.products_id = pc.products_id
                                     and pd.language_id = :language_id
                                     order by p.products_id
                                     ');
      $Qproducts->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $Qproducts->execute();

      while ($products = $Qproducts->fetch()) {
        $product_num++;
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }

    } elseif ($format == 'options.php') {

    } elseif ($format == 'products_extra_fields.php') {

    } elseif ($format == 'manufacturers.php') {

      $Qmanufacturers = $CLICSHOPPING_ExportData->db->prepare('select m.*,
                                                               mi.*
                                                         from  :table_manufacturers m,
                                                              :table_manufacturers_info mi
                                                         where m.manufacturers_id = mi.manufacturers_id
                                                         and mi.languages_id = :language_id
                                                         order by m.manufacturers_id
                                                        ');
      $Qmanufacturers->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $Qmanufacturers->execute();

      while ($manufacturers = $Qmanufacturers->fetch()) {
        $product_num++;
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }

    } elseif ($format == 'suppliers.php') {

      $Qsuppliers = $CLICSHOPPING_ExportData->db->prepare('select s.*,
                                                                   si.*
                                                            from  :table_suppliers s,
                                                                  :table_suppliers_info si
                                                           where s.suppliers_id = si.suppliers_id
                                                           and si.languages_id = :language_id
                                                           order by s.suppliers_id
                                                           ');
      $Qsuppliers->bindInt(':language_id', (int)$CLICSHOPPING_Language->getId());
      $Qsuppliers->execute();

      while ($suppliers = $Qsuppliers->fetch()) {
        $product_num++;
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }
  } elseif ($format == 'customers.php') {

      $Qcustomers = $CLICSHOPPING_ExportData->db->prepare('select c.*,
                                                            a.*
                                                      from :table_customers c left join :table_address_book a on c.customers_default_address_id = a.address_book_id
                                                      where a.customers_id = c.customers_id
                                                      ');
      $Qcustomers->execute();

      while ($customers = $Qcustomers->fetch()) {
        $product_num++;
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }

    } elseif ($format == 'newsletter.php') {

      $Qnewsletter = $CLICSHOPPING_ExportData->db->prepare('select customers_firstname,
                                                                    customers_lastname,
                                                                    customers_email_address
                                                              from  :table_customers
                                                              where customers_newsletter = :customers_newsletter
                                                              and customers_group_id = :customers_group_id
                                                              order by customers_lastname
                                                             ');
      $Qnewsletter->bindValue(':customers_newsletter', 1);
      $Qnewsletter->bindValue(':customers_group_id', 0);
      $Qnewsletter->execute();

      while ($newsletter = $Qnewsletter->fetch()) {
        $product_num++;
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }

    } elseif ($format == 'newsletter_no_account.php') {

      $QnewsletterNoAccount = $CLICSHOPPING_ExportData->db->prepare('select customers_firstname,
                                                                            customers_lastname,
                                                                            customers_email_address
                                                                     from  :table_newsletters_no_account
                                                                     where customers_newsletter = :customers_newsletter
                                                                     order by customers_lastname
                                                                   ');
      $QnewsletterNoAccount->bindValue(':customers_newsletter', 1);

      $QnewsletterNoAccount->execute();

      while ($newsletter_no_account = $QnewsletterNoAccount->fetch()) {
        $product_num++;
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format)) {
          include(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $format);
        }
      }
    }

    $content = $head . $output . $foot;
//Soit on met en cache, soit on affiche le resulat
    if ($cache != "true") {
      Header($header);
      if ($header2) Header($header2);
      echo $content;
    } else {
      $fp = fopen($rep . $fichier, "w");
      fputs($fp, "$content");
      fclose($fp);
      ?>
      <!DOCTYPE html>
      <html <?php echo CLICSHOPPING::getDef('html_params'); ?>>
      <head>
        <meta charset="<?php echo CLICSHOPPING::getDef('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
      </head>
      <body>
      <div style="text-align: center; padding-top:200px;">
        <p>Opération réalisée avec succ&egrave;s - Veuillez fermer cette page <br/></p>
      </div>
      <div style="text-align: center; padding-top:10px;"> Success Operation - Please close this page</div>
      <div style="text-align: center;  padding-top:10px">
        <br/>
        <p>Votre fichier / See your file : <a
            href="<?php echo CLICSHOPPING::link(HTTP::getShopUrlDomain() . 'ext/export/' . $fichier); ?>"><?php echo $fichier; ?></a>
        </p>
      </div>
      <div style="text-align: center;  padding-top:10px">
        <img src="<?php echo '../images/logo_clicshopping_1.png'; ?>"></td>
      </div>
      </body>
      </html>
      <?php
    }
  }

