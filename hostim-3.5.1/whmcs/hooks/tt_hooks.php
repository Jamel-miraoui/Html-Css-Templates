<?php
/**
 * Price Table Hook Function
 *
 * Please refer to the documentation @ https://docs.whmcs.com/Hooks for more information
 * The code in this hook is commented out by default. Uncomment to use.
 *
 * @package    WHMCS
 * @author     WHMCS Limited <development@whmcs.com>
 * @copyright  Copyright (c) WHMCS Limited 2005-2018
 * @license    https://www.whmcs.com/license/ WHMCS Eula
 * @version    $Id$
 * @link       https://www.whmcs.com/
 */

use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\View\Menu\Item as MenuItem;

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");


function __init_settings() {
    $settingsPath = realpath(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "settings.php";

    $settings = [];
    if (file_exists($settingsPath)) {
        $settings = require $settingsPath;
    }

    return $settings;
}

function group_product_feature_hook($vars) {
    $settings            = __init_settings();
    $myStoreProductPages = isset($settings['group_product_feature_page_links']) ? $settings['group_product_feature_page_links'] : [];
    $productGroup        = $vars['productGroup'];

    $includeFeaturePageLink = '';
    if (!empty($productGroup)) {
        $productGroupSlug = $productGroup->slug;
        if (!empty($myStoreProductPages) && !empty($productGroupSlug)) {
            foreach ($myStoreProductPages as $subLink => $featurePageLink) {
                if (strpos($productGroupSlug, $subLink) !== false) {
                    $includeFeaturePageLink = $featurePageLink;
                    break;
                }
            }
        }
    }

    return array("group_product_feature_link" => $includeFeaturePageLink);
}

add_hook("ClientAreaPage", 1, "group_product_feature_hook");



function homepage_price_table_hook($vars) {
    $currencyId   = (isset($_GET['currency']) ? intval($_GET['currency']) : $_SESSION['currency']);
    $currencyList = Capsule::table('tblcurrencies')->get();
    if(empty($currencyid) && !empty($currencyList)) {
        foreach($currencyList as &$currency) {
            if(empty($currencyId) && $currency->default) {
                $currencyId = $currency->id;
            }
        }
    }

    $domainPrices = Capsule::table('tbldomainpricing')
        ->join('tblpricing', 'tbldomainpricing.id', '=', 'tblpricing.relid')
        ->join('tblcurrencies', 'tblpricing.currency', '=', 'tblcurrencies.id')
        ->select('tbldomainpricing.extension','tblpricing.*', 'tblcurrencies.*')
        ->where('tblpricing.type', 'domainregister')
        ->where('tblpricing.currency', $currencyId)
        ->get();

    $encodedata = json_encode($domainPrices);
    $decodedata = json_decode($encodedata, true);

    return array("pricetable" => $decodedata);
}

add_hook("ClientAreaPage", 1, "homepage_price_table_hook");


function homepage_products_hook($vars) {
    $currencyId   = (isset($_GET['currency']) ? intval($_GET['currency']) : $_SESSION['currency']);
    $currencyList = Capsule::table('tblcurrencies')->get();
    if(empty($currencyid) && !empty($currencyList)) {
        foreach($currencyList as &$currency) {
            if(empty($currencyId) && $currency->default) {
                $currencyId = $currency->id;
            }
        }
    }

    $products   = Capsule::table('tblproducts')
        ->join('tblproducts_slugs', 'tblproducts.id', '=', 'tblproducts_slugs.product_id')
        ->join('tblproductgroups', 'tblproducts.gid', '=', 'tblproductgroups.id')
        ->join('tblpricing', 'tblproducts.id', '=', 'tblpricing.relid')
        ->join('tblcurrencies', 'tblpricing.currency', '=', 'tblcurrencies.id')
        ->select('tblproducts.*','tblpricing.*', 'tblcurrencies.*', 'tblproducts_slugs.*')
        ->where('tblproducts.hidden','0')
        ->where('tblproducts_slugs.active', '1')
        ->where('tblproductgroups.hidden', '0')
        ->where('tblpricing.currency', $currencyId)
        ->where('tblpricing.type', 'product')
        ->orderBy("tblproductgroups.order", "ASC")
        ->get();

    $encodeAllProductList  = json_encode($products);
    $allProducts           = json_decode($encodeAllProductList, true);

    $settings              = __init_settings();
    $selectedProductList   = isset($settings['homepage_total_group_product_ids']) ? $settings['homepage_total_group_product_ids'] : [];

    $selectedProductListForHomePage = [];
    if(!empty($allProducts)) {
        foreach ($allProducts as $product) {
            if(array_key_exists($product['relid'], $selectedProductList)) {
                $payType        = $product["paytype"];
                $monthly        = $product["monthly"];
                $quarterly      = $product["quarterly"];
                $semiannually   = $product["semiannually"];
                $annually       = $product["annually"];
                $biennially     = $product["biennially"];
                $triennially    = $product["triennially"];
                if ($payType == "free") {
                    $billingCycle = "Free";
                    $productPrice = "0";
                } else {
                    if ($payType == "onetime") {
                        $billingCycle = "Onetime";
                        $productPrice = $monthly;
                    } else {
                        if ($payType == "recurring") {
                            if (0 <= $monthly) {
                                $billingCycle = "Monthly";
                                $productPrice = $monthly;
                            } else {
                                if (0 <= $quarterly) {
                                    $billingCycle = "Quarterly";
                                    $productPrice = $quarterly;
                                } else {
                                    if (0 <= $semiannually) {
                                        $billingCycle = "Semiannually";
                                        $productPrice = $semiannually;
                                    } else {
                                        if (0 <= $annually) {
                                            $billingCycle = "Annually";
                                            $productPrice = $annually;
                                        } else {
                                            if (0 <= $biennially) {
                                                $billingCycle = "Biennially";
                                                $productPrice = $biennially;
                                            } else {
                                                if (0 <= $triennially) {
                                                    $billingCycle = "Triennially";
                                                    $productPrice = $triennially;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $product['tt_product_product_price'] = $productPrice;
                $product['tt_product_billing_cycle'] = $billingCycle;
                $product['tt_product_icon']       = $selectedProductList[$product['relid']];
                $selectedProductListForHomePage[] = $product;
            }
        }
    }
    
    return array("tt_selectedProductList" => $selectedProductListForHomePage);
}

add_hook("ClientAreaPage", 1, "homepage_products_hook");



add_hook('ClientAreaPrimaryNavbar', 1, function (MenuItem $primaryNavbar) {
    global $_LANG;
    // remove Network Status
    if (!is_null($primaryNavbar->getChild('Network Status'))) {
        $primaryNavbar->removeChild('Network Status');
    }

    // remove Affiliates
    if (!is_null($primaryNavbar->getChild('Affiliates'))) {
        //   $primaryNavbar->removeChild('Affiliates');
    }

    // Rename Announcements
    if (!is_null($primaryNavbar->getChild('Announcements'))) {
        $primaryNavbar->getChild("Announcements")->setLabel($_LANG['news']);
    }

    // after logged in topmenu: Rename Announcements
    if (!is_null($primaryNavbar->getChild('Support'))) {
        $primaryNavbar->getChild('Support')->getChild("Announcements")->setLabel($_LANG['news']);
    }

    // after logged in topmenu: Rename Announcements
    if (!is_null($primaryNavbar->getChild('Website Security'))) {
        $primaryNavbar->getChild('Website Security')->setLabel($_LANG['security']);
    }

    // sidebar menu
    $secondarySidebar = Menu::secondarySidebar();
    if (!is_null($secondarySidebar->getChild('Support'))) {
        $secondarySidebar->getChild('Support')->getChild("Announcements")->setLabel($_LANG['news']);
    }

});

add_hook('ClientAreaSecondaryNavbar', 1, function (MenuItem $secondaryNavbar) {

    $client = Menu::context('client');
    if (!is_null($client) && !is_null($secondaryNavbar->getChild('Account'))) {
        $secondaryNavbar->getChild('Account')->setIcon('fal fa-user');
    }
});



function multiple_currency_hook($vars) {
    $currencyId   = (isset($_GET['currency']) ? intval($_GET['currency']) : $_SESSION['currency']);

    $currencyList = Capsule::table('tblcurrencies')->get();
    if(!empty($currencyList)) {
        $template   = !empty($vars['template']) ? $vars['template'] : '';
        $settings   = __init_settings();
        $flags      = isset($settings['current_flag_icons']) ? $settings['current_flag_icons'] : [];
        foreach($currencyList as &$currency) {
            $currency->flag = 'templates' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . $flags[$currency->code];
            if(empty($currencyId) && $currency->default) {
                $currencyId = $currency->id;
            }
        }
    }

    $encodedata = json_encode($currencyList);
    $decodedata = json_decode($currencyList, true);

    $urlForCurrentcy = __get_url_for_currency($currencyId);
    $isQueryExist    = strpos($urlForCurrentcy, "?") !== false ? true : false;

    return array("multiCurrency" => $decodedata, 'selectedCurrency' => $currencyId, 'urlForCurrentcy' => $urlForCurrentcy, 'isQueryExist' => $isQueryExist);
}

add_hook("ClientAreaPage", 1, "multiple_currency_hook");

// get URL for currency withour currency query string
function __get_url_for_currency($currencyId) {
    $whmcsQueryStr   = [];
    $actualLink      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $whmcsCurrentUrl = parse_url($actualLink);
    if(!empty($whmcsCurrentUrl['query'])) {
        parse_str($whmcsCurrentUrl['query'], $whmcsQueryStr);
    }

    if(!empty($whmcsQueryStr)) {
        foreach($whmcsQueryStr as $queryKey => $whmcsQuery) {
            if(strpos($queryKey, "currency") !== false) {
                unset($whmcsQueryStr[$queryKey]);
            }
        }
    }

    $whmcsCurrentUrl['query']  = urldecode(http_build_query($whmcsQueryStr, '', '&amp;'));

    $fullUrl = __un_parse_url($whmcsCurrentUrl);

    return $fullUrl;
}

// prepare full URL
function __un_parse_url( $parsed_url , $ommit = array( ) ) {
    $url           = '';
    $p             = array();
    $p['scheme']   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : '';
    $p['host']     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : '';
    $p['port']     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : '';
    $p['user']     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : '';
    $p['pass']     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass']  : '';
    $p['pass']     = ( $p['user'] || $p['pass'] ) ? $p['pass']."@" : '';
    $p['path']     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';
    $p['query']    = !empty( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';
    $p['fragment'] = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';
    if ( $ommit ) {
        foreach ( $ommit as $key ) {
            if ( isset( $p[ $key ] ) ) {
                $p[ $key ] = '';
            }
        }
    }

    return $p['scheme'].$p['user'].$p['pass'].$p['host'].$p['port'].$p['path'].$p['query'].$p['fragment'];
}

function load_style_for_template($vars) {
    $settings        = __init_settings();
    $defaultTemplate = isset($settings['default_template']) ? $settings['default_template'] : null;
    $isRtlTemplate   = isset($settings['is_template_rtl']) ? $settings['is_template_rtl'] : false;
    $templateCustomStyleFileLink = isset($settings['template_custom_style_file_link']) ? $settings['template_custom_style_file_link'][$defaultTemplate] : [];

    return array('is_template_rtl' => $isRtlTemplate, 'tt_default_template_name' => $defaultTemplate, 'tt_template_custom_style_link' => $templateCustomStyleFileLink);
}

add_hook("ClientAreaPage", 1, "load_style_for_template");


function get_debug_mode($vars) {
    $settings        = __init_settings();
    $debugMode = isset($settings['tt_debug_mode']) ? $settings['tt_debug_mode'] : false;

    return array('tt_debug_mode' => $debugMode);
}

add_hook("ClientAreaPage", 1, "get_debug_mode");

function pr($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}