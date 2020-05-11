<?php
/**
 * Plugin Social
 *
 * Add links to share links to several social networks + mailto.
 *
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

/**
 * Initialization function.
 * It will be called when the plugin is loaded.
 * This function can be used to return a list of initialization errors.
 *
 * @param $conf ConfigManager instance.
 *
 * @return array List of errors (optional).
 */
function social_init($conf)
{
    if (! $conf->exists('translation.extensions.social')) {
        // Custom translation with the domain 'social'
        $conf->set('translation.extensions.social', 'plugins/social/languages/');
        $conf->write(true);
    }

    return $errors;
}

/**
 * Hook render_includes.
 * Executed on every page redering.
 *
 * Template placeholders:
 *   - css_files
 *
 * Data:
 *   - _PAGE_: current page
 *   - _LOGGEDIN_: true/false
 *
 * @param array $data data passed to plugin
 *
 * @return array altered $data.
 */
function hook_social_render_includes($data)
{
    $data['css_files'][] = PluginManager::$PLUGINS_PATH . '/social/social.css';
    return $data;
}

/*
 * SPECIFIC PAGES
 */

/**
 * Hook render_linklist.
 *
 * Template placeholders:
 *   - action_plugin: next to 'private only' button.
 *   - plugin_start_zone: page start
 *   - plugin_end_zone: page end
 *   - link_plugin: icons below each links.
 *
 * Data:
 *   - _LOGGEDIN_: true/false
 *
 * @param array $data data passed to plugin
 *
 * @return array altered $data.
 */
function hook_social_render_linklist($data)
{
    $social_html = file_get_contents(PluginManager::$PLUGINS_PATH . '/social/social.html');
    foreach ($data['links'] as &$value) {
        $social = sprintf($social_html, urlencode($value['url']), urlencode($value['title']));
        $value['link_plugin'][] = $social;
    }
    return $data;   
}

/**
 * This function is never called, but contains translation calls for GNU gettext extraction.
 */
function default_social_translation()
{
    // meta
    social_t('Add links to share your links to main social networks or by email (mailto).');
    social_t('show Diaspora*');
    social_t('show Twitter');
    social_t('show Facebook');
    social_t('show Google');
    social_t('show LinkedIn');
    social_t('show Pinterest');
    social_t('show Scoop.it');
    social_t('show mail');
}