<?php


include_once('BootstrapShare_LifeCycle.php');

class BootstrapShare_Plugin extends BootstrapShare_LifeCycle {

    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        //  http://plugin.michael-simpson.com/?page_id=31
        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
            'Show_Facebook'   => array(__('Show Facebook link', 'bootstrap-share'),    'true', 'false'),
            'Show_Twitter'    => array(__('Show Twitter link', 'bootstrap-share'),     'true', 'false'),
            'Show_GooglePlus' => array(__('Show Google Plus link', 'bootstrap-share'), 'true', 'false'),
            'Show_LinkedIn'   => array(__('Show LinkedIn link', 'bootstrap-share'),    'true', 'false'),
            'Show_Pinterest'  => array(__('Show Pinterest link', 'bootstrap-share'),   'true', 'false')
        );
    }

//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

    protected function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }
    }

    public function getPluginDisplayName() {
        return 'Bootstrap Share Icons';
    }

    protected function getMainPluginFileName() {
        return 'bootstrap-share.php';
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * See: http://plugin.michael-simpson.com/?page_id=35
     * @return void
     */
    public function upgrade() {
    }

    public function addActionsAndFilters() {

        // Add options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));

        // Example adding a script & style just for the options administration page
        // http://plugin.michael-simpson.com/?page_id=47
        //        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        }


        // Add Actions & Filters
        // http://plugin.michael-simpson.com/?page_id=37
        add_filter('the_content', array(&$this, 'createShareIcons'));

        // Adding scripts & styles to all pages
        // Examples:
        //        wp_enqueue_script('jquery');
        //        wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));


        // Register short codes
        // http://plugin.michael-simpson.com/?page_id=39


        // Register AJAX hooks
        // http://plugin.michael-simpson.com/?page_id=41

    }

    public function createShareIcons($content) {
      if (is_single()) {
        $url = urlencode(get_permalink());
        $title = urlencode(get_the_title());
        $msg = urlencode('Check this out!');
        $content .= '<aside class="bootstrap-share" id="sharing-icons">'.PHP_EOL;
        $content .= '  <h2>Share</h2>'.PHP_EOL;
        $content .= '  <ul>'.PHP_EOL;
        # Facebook share link
        if ($this->getOption('Show_Facebook') == 'true') {
          $content .= '    <li><a href="http://www.facebook.com/sharer.php?u='.$url.'&t='.$title.'" title="Share on Facebook">';
          $content .= '<i class="icon-facebook"></i>';
          $content .= '</a></li>'.PHP_EOL;
        }
        # Twitter share link
        if ($this->getOption('Show_Twitter') == 'true') {
          $content .= '    <li><a href="http://twitter.com/share?url='.$url.'&text='.$msg.'" title="Share on Twitter">';
          $content .= '<i class="icon-twitter"></i>';
          $content .= '</a></li>'.PHP_EOL;
        }
        # G+ share link
        if ($this->getOption('Show_GooglePlus') == 'true') {
          $content .= '    <li><a href="https://plus.google.com/share?url='.$url.'" title="Share on Google Plus">';
          $content .= '<i class="icon-google-plus"></i>';
          $content .= '</a></li>'.PHP_EOL;
        }
        # LinkedIn share link
        if ($this->getOption('Show_LinkedIn') == 'true') {
          $content .= '    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url='.$url.'&title='.$title.'" title="Share on LinkedIn">';
          $content .= '<i class="icon-linkedin"></i>';
          $content .= '</a></li>'.PHP_EOL;
        }
        # Pinterest share link
        if ($this->getOption('Show_Pinterest') == 'true') {
          $content .= '    <li><a href="http://pinterest.com/pin/create/button/?url='.$url.'&media=&description='.$title.'" title="Share on Pinterest">';
          $content .= '<i class="icon-pinterest"></i>';
          $content .= '</a></li>'.PHP_EOL;
        }
        $content .= '  </ul>'.PHP_EOL;
        $content .= '</aside>'.PHP_EOL;
      }
      return $content;
    }
}
