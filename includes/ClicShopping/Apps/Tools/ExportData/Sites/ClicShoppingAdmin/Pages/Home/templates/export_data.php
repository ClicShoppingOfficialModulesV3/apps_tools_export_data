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
  use ClicShopping\OM\FileSystem;

  $CLICSHOPPING_ExportData = Registry::get('ExportData');
  $CLICSHOPPING_Template = Registry::get('TemplateAdmin');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();
  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
  $CLICSHOPPING_Language = Registry::get('Language');

  $language_id = $CLICSHOPPING_Language->getId();

  $QCountProducts = $CLICSHOPPING_ExportData->db->prepare('select count(p.products_id) as count_products
                                                           from :table_products p,
                                                                :table_products_description pd
                                                           where p.products_status = 1
                                                           and p.products_archive = 0
                                                           and p.products_quantity > 0
                                                           and p.products_id = pd.products_id
                                                           and pd.language_id = :language_id
                                                           and p.products_price_comparison = 0
                                                          ');

  $QCountProducts->bindInt(':language_id', $language_id);

  $QCountProducts->execute();

  $count_products = $QCountProducts->fetch();

  $error = false;

  if (!FileSystem::isWritable(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'ext/export/')) {
    $directory = CLICSHOPPING::getConfig('dir_root', 'Shop') . 'ext/export/';
    $error = true;
  }

  if (!FileSystem::isWritable(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'ext/export/secure/')) {
    $directory_1 = CLICSHOPPING::getConfig('dir_root', 'Shop') . 'ext/export/secure/';
    $error = true;
  }
?>
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span
            class="col-md-1"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/comparison_export.gif', $CLICSHOPPING_ExportData->getDef('heading_title'), '40', '40'); ?></span>
          <span
            class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_ExportData->getDef('heading_title'); ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <?php
    if ($error === true) {
      $security = '<div class="alert alert-danger text-center" role="alert">';
      $security .= '<p class="text-center"><strong>' . $CLICSHOPPING_ExportData->getDef('text_error_directory_writeable') . ' ' . $directory . '  - ' . $directory_1 . '</span></p>';
      $security .= '</div>';

      echo $security;
      echo '<div class="searator"></div>';
    }

    echo HTML::form('ExU', null, 'post');
    /*
      function netoyage_html() {
        return false;
      }
    */
    $comparateur = array(['id' => '',
      'text' => '-- ' . $CLICSHOPPING_ExportData->getDef('comparateur_select_export') . ' --'
    ]);

    if (is_dir(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/')) {
      $dir = opendir(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/');
    }

    while ($fichier = readdir($dir)) {

      if (substr($fichier, -3) == 'php' && substr($fichier, 0) != 'index.php') {
        if (is_file(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $fichier)) {
          include_once(CLICSHOPPING::getConfig('dir_root', 'Shop') . 'includes/Module/Export/ClicShoppingAdmin/' . $fichier);
        }

        foreach ($comp as $value) {
          $comparateur[] = ['id' => $fichier,
            'text' => $value
          ];
        }
      }
    }

    closedir($dir);

    $languages = $CLICSHOPPING_Language->getLanguages();
    $languages_array = [];
    $languages_selected = DEFAULT_LANGUAGE;

    for ($i = 0, $n = count($languages); $i < $n; $i++) {
      $languages_array[] = ['id' => $languages[$i]['code'],
        'text' => $languages[$i]['name']
      ];
    }
  ?>

  <div class="mainTitle"><?php echo $CLICSHOPPING_ExportData->getDef('text_title_export'); ?></div>
  <div class="adminformTitle">

    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_ExportData->getDef('comparateur_select'); ?>"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_ExportData->getDef('comparateur_select'); ?></label>
          <div class="col-md-5">
            <?php echo HTML::selectMenu('format', $comparateur, '', 'onchange ="affiche()"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <div class="col-md-5">
            <?php echo HTML::hiddenField('p', EXPORT_CODE, 'onblur ="affiche()"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_ExportData->getDef('comparateur_lng'); ?>"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_ExportData->getDef('comparateur_lng'); ?></label>
          <div class="col-md-5">
            <?php echo HTML::selectMenu('language', $languages_array, '', 'onchange ="affiche()"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_ExportData->getDef('comparateur_cache'); ?>"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_ExportData->getDef('comparateur_cache'); ?></label>
          <div class="col-md-5">
            <input type="radio" name="cache" value="true" onChange="affiche()"/>
            <?php echo $CLICSHOPPING_ExportData->getDef('comparateur_oui'); ?>
            <input name="cache" type="radio" value="false" checked="checked" onChange="affiche()"/>
            <?php echo $CLICSHOPPING_ExportData->getDef('comparateur_non'); ?>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_ExportData->getDef('comparateur_fichier'); ?>"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_ExportData->getDef('comparateur_fichier'); ?></label>
          <div class="col-md-5">
            <?php echo HTML::inputField('fichier', '', 'onchange ="affiche()"'); ?><?php echo ' ' . $CLICSHOPPING_ExportData->getDef('comparateur_oblig'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group row">
          <label
            class="col-4 col-form-label"><?php echo $CLICSHOPPING_ExportData->getDef('comparateur_champ'); ?></label>
          <div class="col-md-8">
              <span class="col-md-3"><?php echo HTML::inputField('libre', '', 'onchange ="affiche()"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <div class="col-md-12">
            <span class="col-md-9"><?php echo $CLICSHOPPING_ExportData->getDef('comparateur_url'); ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="form-group row">
          <div class="col-md-12">
            <?php echo HTML::inputField('url', '', 'size="125"'); ?>
          </div>
        </div>
      </div>
    </div>

  </div>
  </form>
  <div class="separator"></div>
  <div class="alert alert-info">
    <div><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/help.gif', $CLICSHOPPING_ExportData->getDef('title_help_export')) . ' ' . $CLICSHOPPING_ExportData->getDef('title_help_export') ?></div>
    <div class="separator"></div>
    <div><?php echo $CLICSHOPPING_ExportData->getDef('text_help_export', ['url' => CLICSHOPPING::link('ext/export/myfile.xml')]); ?></div>
  </div>

</div>


<script language="Javascript">
    function affiche() {
        var val;
        val = "<?php echo $CLICSHOPPING_ExportData->link('ExportDb&format='); ?>";
        val += document.ExU.format.value;
        val += "&p=";
        val += document.ExU.p.value;
        val += "&language=";
        val += document.ExU.language.value;


        if (document.ExU.cache[0].checked) {
            val += "&cache=";
            val += document.ExU.cache[0].value;
            val += "&fichier=";
            val += document.ExU.fichier.value;

        }
        val += "&libre=";
        val += document.ExU.libre.value;
        document.ExU.url.value = val;
    }
</script>