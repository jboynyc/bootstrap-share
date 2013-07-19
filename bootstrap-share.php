<?php
/*
   Plugin Name: Bootstrap Share Icons
   Plugin URI: http://github.com/jboynyc/bootstrap-share
   Version: 0.1
   Author: jboy
   Description: Add sharing icons to the bottom of posts using Font Awesome.
   Text Domain: 
   License: GPLv3
  */

/*
    "WordPress Plugin Template" Copyright (C) 2013 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This following part of this file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

$BootstrapShare_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function BootstrapShare_noticePhpVersionWrong() {
    global $BootstrapShare_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "Bootstrap Share Icons" requires a newer version of PHP to be running.',  '').
            '<br/>' . __('Minimal version of PHP required: ', '') . '<strong>' . $BootstrapShare_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', '') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}


function BootstrapShare_PhpVersionCheck() {
    global $BootstrapShare_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $BootstrapShare_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'BootstrapShare_noticePhpVersionWrong');
        return false;
    }
    return true;
}


/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @return void
 */
function BootstrapShare_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('', false, $pluginDir . '/languages/');
}


//////////////////////////////////
// Run initialization
/////////////////////////////////

// First initialize i18n
BootstrapShare_i18n_init();


// Next, run the version check.
// If it is successful, continue with initialization for this plugin
if (BootstrapShare_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('bootstrap-share_init.php');
    BootstrapShare_init(__FILE__);
}
