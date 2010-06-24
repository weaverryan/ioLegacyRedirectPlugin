<?php
/**
 * Plugin configuration for ioLegacyRedirect.
 * 
 * @package     ioLegacyRedirectPlugin
 * @subpackage  config
 * @author      Ryan Weaver <ryan.weaver@iostudio.com>
 * @copyright   Iostudio, LLC 2010
 * @since       2010-06-24
 * @version     svn:$Id$ $Author$
 */
class ioLegacyRedirectPluginConfiguration extends sfPluginConfiguration
{
  /**
   * Hooks up with the context.load_factories event
   *
   * @return void
   */
  public function initialize()
  {
    $this->dispatcher->connect('context.load_factories', array($this, 'bootstrap'));
    $this->dispatcher->connect('routing.load_configuration', array($this, 'listenToRoutingLoadConfiguration'));
  }

  /**
   * Listens to the context.load_factories event and enables the plugin module
   *
   * @param sfEvent $event The context.load_factories event
   * @return void
   */
  public function bootstrap(sfEvent $event)
  {
    // enable the ioLegacyRedirect module automatically
    $enabledModules = sfConfig::get('sf_enabled_modules', array());
    $enabledModules = array_merge($enabledModules, array('ioLegacyRedirect'));
    sfConfig::set('sf_enabled_modules', $enabledModules);
  }

  /**
   * Adds new routes to support the legacy urls
   *
   * @throws sfException
   * @param  $event The routing.load_configuration event
   * @return void
   */
  public function listenToRoutingLoadConfiguration($event)
  {
    // load in the legacy routes
    $legacyUrls = sfConfig::get('app_legacy_redirect_urls', array());
    $routing = $event->getSubject();

    foreach ($legacyUrls as $key => $legacyUrl)
    {
      if (!isset($legacyUrl['old_url']))
      {
        throw new sfException(sprintf('Legacy url "%s" must have key "old_url', $key));
      }
      if (!isset($legacyUrl['new_route']))
      {
        throw new sfException(sprintf('Legacy url "%s" must have key "new_route', $key));
      }

      $route = new sfRoute($legacyUrl['old_url'], array(
        'module'    => 'ioLegacyRedirect',
        'action'    => 'redirect',
        'new_route' => $legacyUrl['new_route'],
      ));

      $routing->appendRoute('legacy_redirect_'.$key, $route);
    }
  }
}
