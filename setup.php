<?php

use Glpi\Plugin\Hooks;

define('PLUGIN_WHATSAPPNOTIFICATION_VERSION', '0.0.1');
define('PLUGIN_WHATSAPPNOTIFICATION_MIN_GLPI', '10.0.0');
define('PLUGIN_WHATSAPPNOTIFICATION_MAX_GLPI', '10.0.99');

/**
 * Init hooks of the plugin.
 * REQUIRED
 *
 * @return void
 */
function plugin_init_whatsappnotification() {
   global $PLUGIN_HOOKS,$CFG_GLPI;


   // Config page
   if (Session::haveRight('config', UPDATE)) {
      $PLUGIN_HOOKS['config_page']['whatsappnotification'] = 'front/config.php';
   }

   // Init session
   $PLUGIN_HOOKS['item_add']['whatsappnotification']  = ['Ticket' => 'plugin_whatsappnotification_item_add'];
   $PLUGIN_HOOKS['csrf_compliant']['whatsappnotification'] = true;

}


/**
 * Get the name and the version of the plugin
 * REQUIRED
 *
 * @return array
 */
function plugin_version_whatsappnotification() {
   return [
      'name'           => 'whatsappnotification',
      'version'        => PLUGIN_WHATSAPPNOTIFICATION_VERSION,
      'author'         => 'luciano@citrait.com.br',
      'license'        => 'GPLv2+',
      'homepage'       => 'https://github.com/citrait/glpi-whatsapp-notifications',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_WHATSAPPNOTIFICATION_MIN_GLPI,
            'max' => PLUGIN_WHATSAPPNOTIFICATION_MAX_GLPI,
         ]
      ]
   ];
}


/**
 * Check pre-requisites before install
 * OPTIONNAL, but recommanded
 *
 * @return boolean
 */
function plugin_whatsappnotification_check_prerequisites() {
   if (false) {
      return false;
   }
   return true;
}

/**
 * Check configuration process
 *
 * @param boolean $verbose Whether to display message on failure. Defaults to false
 *
 * @return boolean
 */
function plugin_whatsappnotification_check_config($verbose = false) {
   if (true) { // Your configuration check
      return true;
   }

   if ($verbose) {
      echo __('Installed / not configured', 'whatsappnotification');
   }
   return false;
}
