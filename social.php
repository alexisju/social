<?php
/**
 * Plugin Social
 *
 * Add links to share links to several social networks + mailto.
 */

/*
 * RENDER HEADER, INCLUDES, FOOTER
 *
 * Those hooks are called at every page rendering.
 * You can filter its execution by checking _PAGE_ value
 * and check user status with _LOGGEDIN_.
 */

use Shaarli\Config\ConfigManager;
use Shaarli\Plugin\PluginManager;
use Shaarli\Router;

/**
 * In the footer hook, there is a working example of a translation extension for Shaarli.
 *
 * The extension must be attached to a new translation domain (i.e. NOT 'shaarli').
 * Use case: any custom theme or non official plugin can use the translation system.
 *
 * See the documentation for more information.
 */
const EXT_TRANSLATION_DOMAIN = 'social';

/*
 * This is not necessary, but it's easier if you don't want Poedit to mix up your translations.
 */
function social_t($text, $nText = '', $nb = 1)
{
    return t($text, $nText, $nb, EXT_TRANSLATION_DOMAIN);
}

function hook_social_render_includes($data)
{
    $data['css_files'][] = PluginManager::$PLUGINS_PATH . '/social/social.css';
    return $data;
}
 
function hook_social_render_linklist($data)
{
    $social_html = file_get_contents(PluginManager::$PLUGINS_PATH . '/social/social.html');
    foreach ($data['links'] as &$value) {
        $social = sprintf($social_html, urlencode($value['url']), urlencode($value['title']));
        $value['link_plugin'][] = $social;
    }
    return $data;   
}
