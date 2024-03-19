<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//
////var_dump(__DIR__. DIRECTORY_SEPARATOR .     "loadTheme.php"); die;
//
//$settingsPath = realpath(__DIR__) . DIRECTORY_SEPARATOR . "loadTheme.php";
//if (file_exists($settingsPath)) {
//    require $settingsPath;
//}
//
//die;
$settings = [];

$settings['group_product_feature_page_links'] = [
    "web-hosting"          => "includes/tt/tt-web-hosting.tpl",
    "reseller-hosting"     => "includes/tt/tt-reseller-hosting.tpl",
    "vps-hosting"          => "includes/tt/tt-vps-hosting.tpl",
    "dedicated-hosting"    => "includes/tt/tt-dedicated-hosting.tpl",
];

/*
 * Fist product of the group will be show
 * Purpose: Limit of total group's product
 *
*/
$settings['homepage_total_group_product_ids'] = [
    46 => "img/icon-price-1.svg",
    47 => "img/icon-price-2.svg",
    48 => "img/icon-price-3.svg",
    49 => "img/icon-price-4.svg",
];


// ************************************************************************************************************************
// Description: All flag list with currency code (We used flag from https://lipis.github.io/flag-icon-css/flags/4x3/us.svg.)
// key: currency code from WHMCS setting (Configuration > System Settings > Currencies). https://docs.whmcs.com/Currencies
// value: flag image path. Location: templates/{your-template}/img/flags/
//
// Instruction: the key needs to be same as the currency code.
// Example: 'USD'. We have set the currency code USD from Configuration > System Settings > Currencies
// ************************************************************************************************************************
$settings['current_flag_icons'] = [
    'AED' => 'img/flags/AED.svg',
    'AUD' => 'img/flags/AUD.svg',
    'BDT' => 'img/flags/BDT.svg',
    'BRL' => 'img/flags/BRL.svg',
    'COP' => 'img/flags/COP.svg',
    'CRC' => 'img/flags/CRC.svg',
    'DEM' => 'img/flags/DEM.svg',
    'EGP' => 'img/flags/EGP.svg',
    'ESP' => 'img/flags/ESP.svg',
    'FRF' => 'img/flags/FRF.svg',
    'GBP' => 'img/flags/GBP.svg',
    'IDR' => 'img/flags/IDR.svg',
    'ILS' => 'img/flags/ILS.svg',
    'INR' => 'img/flags/INR.svg',
    'ITL' => 'img/flags/ITL.svg',
    'MXN' => 'img/flags/MXN.svg',
    'NGN' => 'img/flags/NGN.svg',
    'NLG' => 'img/flags/NLG.svg',
    'PKR' => 'img/flags/PKR.svg',
    'PLN' => 'img/flags/PLN.svg',
    'SAR' => 'img/flags/SAR.svg',
    'TRY' => 'img/flags/TRY.svg',
    'USD' => 'img/flags/USD.svg',
];

$settings['tt_debug_mode']    = false;

return $settings;
