<?php
/**
 * Plugin Social
 *
 * Add links to share links to several social networks + mailto.
 */
 
function hook_social_render_includes($data)
{
    $data['css_files'][] = PluginManager::$PLUGINS_PATH . '/social/social.css';
    return $data;
}
 
function hook_social_render_linklist($data)
{
    $social_html = file_get_contents(PluginManager::$PLUGINS_PATH . '/social/social.html');
    foreach ($data['links'] as &$value) {
        $social = sprintf($social_html, $value['real_url'], $value['title']);
        $value['link_plugin'][] = $social;
    }
    return $data;   
}
