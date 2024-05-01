<?php

// Non menu entry case
//header("Location:../../central.php");

// Entry menu case
include ("../../../inc/includes.php");

Session::checkRight("config", UPDATE);

// To be available when plugin in not activated
Plugin::load('whatsappnotification');

Html::header("TITRE", $_SERVER['PHP_SELF'], "config", "plugins");
echo __("This is the plugin config page", 'whatsappnotification');
Html::footer();
