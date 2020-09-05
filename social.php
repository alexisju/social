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

const SOCIAL_SHARE = [
  'SOCIAL_ENABLE_SHARE_ON_DISPORA',
  'SOCIAL_ENABLE_SHARE_ON_TWITTER',
  'SOCIAL_ENABLE_SHARE_ON_FACEBOOK',
  'SOCIAL_ENABLE_SHARE_ON_GOOGLE',
  'SOCIAL_ENABLE_SHARE_ON_LINKEDIN',
  'SOCIAL_ENABLE_SHARE_ON_PINTEREST',
  'SOCIAL_ENABLE_SHARE_ON_SCOOP',
  'SOCIAL_ENABLE_SHARE_ON_MAIL',
];

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
  $params = '';
  foreach (SOCIAL_SHARE as $placeholder) {
    $params .= trim($conf->get('plugins.'. $placeholder, ''));
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
function hook_social_render_linklist($data, $parameter)
{
  $config = $parameter->get('plugins');
  $social_html='<!-- Socialplugin --><ul class="socialplugin">';

  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_DISPORA'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Diaspora*" href="http://sharetodiaspora.github.io/?url=%1$s&amp;title=%2$s" rel="nofollow" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700\');return false;"><img src="https://upload.wikimedia.org/wikipedia/commons/6/64/Diaspora_logotype.svg" alt="diaspora*"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_TWITTER'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Twitter" href="https://twitter.com/share?url=%1$s&amp;text=%2$s" rel="nofollow" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700\');return false;"><img src="../plugins/social/icons/Twitter.svg" alt="twitter"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_FACEBOOK'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Facebook" href="https://www.facebook.com/sharer.php?u=%1$s&amp;t=%2$s" rel="nofollow" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700\');return false;"><img src="../plugins/social/icons/Facebook (2).svg" alt="facebook"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_GOOGLE'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Google +" href="https://plus.google.com/share?url=%1$s&amp;hl=fr" rel="nofollow" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650\');return false;"><img src="../plugins/social/icons/googleplusicon.svg" alt="google+"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_LINKEDIN'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="LinkedIn" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=%1$s&amp;title=%2$s" rel="nofollow" onclick="javascript:window.open(this.href, \'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650\');return false;"><img src="../plugins/social/icons/linkedin.svg" alt="linkedin"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_PINTEREST'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Pinterest" href="http://pinterest.com/pin/create/button/?url=%1$s&amp;media=%1$s&amp;description=%2$s" rel="nofollow" onclick="javascript:window.open(this.href, \'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650\');return false;"><img src="../plugins/social/icons/Pinterest.svg" alt="pinterest"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_SCOOP'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Scoop.it" href="http://www.scoop.it/oexchange/share?url=%1$s&amp;title=%2$s" rel="nofollow" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=800px,width=1150px\');return false;"><img src="https://www.scoop.it/resources/img/homepage/logo-scoopit-blue.png" alt="scoop.it"></a></li>';
  }
  if(filter_var($config['SOCIAL_ENABLE_SHARE_ON_MAIL'], FILTER_VALIDATE_BOOLEAN)){
    $social_html.='<li><a target="_blank" title="Envoyer par mail" href="mailto:?subject=%2$s&amp;body=%1$s" rel="nofollow">📧email</a>';
  }
  $social_html.='</ul><!-- /Socialplugin -->';

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
