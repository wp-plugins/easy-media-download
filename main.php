<?php
/*
Plugin Name: Easy Media Download
Version: 1.0.1
Plugin URI: http://noorsplugin.com/easy-media-download-plugin-for-wordpress/
Author: naa986
Author URI: http://noorsplugin.com/
Description: Easily embed download buttons for your digital media files
*/

if(!defined('ABSPATH')) exit;
if(!class_exists('EASY_MEDIA_DOWNLOAD'))
{
    class EASY_MEDIA_DOWNLOAD
    {
        var $plugin_version = '1.0.1';
        function __construct()
        {
            define('EASY_MEDIA_DOWNLOAD_VERSION', $this->plugin_version);
            $this->plugin_includes();
        }
        function plugin_includes()
        {
            if(is_admin( ) )
            {
                //add_filter('plugin_action_links', array(&$this,'add_plugin_action_links'), 10, 2 );
            }
            //add_action('admin_menu', array( &$this, 'add_options_menu' ));
            add_shortcode('easy_media_download','easy_media_download_handler');
        }
        function plugin_url()
        {
            if($this->plugin_url) return $this->plugin_url;
            return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
        }
        function add_plugin_action_links($links, $file)
        {
            if ( $file == plugin_basename( dirname( __FILE__ ) . '/main.php' ) )
            {
                $links[] = '<a href="options-general.php?page=easy-media-download-settings">Settings</a>';
            }
            return $links;
        }

        function add_options_menu()
        {
            if(is_admin())
            {
                add_options_page('Easy Media Download Settings', 'Easy Media Download', 'manage_options', 'easy-media-download-settings', array(&$this, 'display_options_page'));
            }
        }
    }
    $GLOBALS['easy_media_download'] = new EASY_MEDIA_DOWNLOAD();
}

function easy_media_download_handler($atts)
{
    extract(shortcode_atts(array(
        'url' => '',
        'text' => 'Download Now',
        'width' => '153',
        'height' => '41',
    ), $atts));
    $styles = <<<EOT
    <style type="text/css">
    .easy_media_dl_button {
        -moz-box-shadow:inset 0px 1px 0px 0px #f5978e;
        -webkit-box-shadow:inset 0px 1px 0px 0px #f5978e;
        box-shadow:inset 0px 1px 0px 0px #f5978e;
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f24537), color-stop(1, #c62d1f) );
        background:-moz-linear-gradient( center top, #f24537 5%, #c62d1f 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f24537', endColorstr='#c62d1f');
        background-color:#f24537;
        -webkit-border-top-left-radius:0px;
        -moz-border-radius-topleft:0px;
        border-top-left-radius:0px;
        -webkit-border-top-right-radius:0px;
        -moz-border-radius-topright:0px;
        border-top-right-radius:0px;
        -webkit-border-bottom-right-radius:0px;
        -moz-border-radius-bottomright:0px;
        border-bottom-right-radius:0px;
        -webkit-border-bottom-left-radius:0px;
        -moz-border-radius-bottomleft:0px;
        border-bottom-left-radius:0px;
        text-indent:0;
        border:1px solid #d02718;
        display:inline-block;
        color:#ffffff !important;
        font-family:Georgia;
        font-size:15px;
        font-weight:bold;
        font-style:normal;
        height:{$height}px;
        line-height:{$height}px;
        width:{$width}px;
        text-decoration:none;
        text-align:center;
        text-shadow:1px 1px 0px #810e05;
    }
    .easy_media_dl_button:hover {
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #c62d1f), color-stop(1, #f24537) );
        background:-moz-linear-gradient( center top, #c62d1f 5%, #f24537 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#c62d1f', endColorstr='#f24537');
        background-color:#c62d1f;
    }.easy_media_dl_button:active {
        position:relative;
        top:1px;
    }
    </style>
EOT;
    $output = <<<EOT
    <a href="$url" class="easy_media_dl_button">$text</a>
    $styles
EOT;
    return $output;
}
