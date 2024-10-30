<?php
/**
 * Plugin Name: LNC Near Comments
 * Description: verify comments with nCaptcha
 * Version: 0.1.3
 * Author: Learn NEAR Club
 * Author URI: http://learnnear.club/
 */

use \LNCNearComments\Model\Constructor\Constructor;

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

try {
    $composerLoader = __DIR__ . '/vendor/autoload.php';
    if (file_exists($composerLoader)) {
        require_once $composerLoader;
    } else {
        throw new Exception(__('Install the composer for current work', 'lnc-n-comments'));
    }
    if (!is_plugin_active('near-login/index.php')) {
        throw new Exception(__('Login With NEAR should be enabled'));
    }
    Constructor::getInstance();
} catch (Exception $exception) {
    deactivate_plugins('lnc-n-comments/index.php');
    add_action('admin_notices', function() use ($exception) {
        echo '<div class="error"><p>' . esc_html($exception->getMessage()) . '</p></div>';
    });
}

