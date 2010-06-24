<?php
/**
 * All legacy urls are sent to this module, where they are redirected
 * to the correct location
 * 
 * @package     ioLegacyRedirectPlugin
 * @subpackage  actions
 * @author      Ryan Weaver <ryan.weaver@iostudio.com>
 * @copyright   Iostudio, LLC 2010
 * @since       2010-06-24
 * @version     svn:$Id$ $Author$
 */
class BaseioLegacyRedirectActions extends sfActions
{

  /**
   * All legacy urls are routed to this action, which redirects to the
   * correct new route.
   *
   * @param sfWebRequest $request
   * @return void
   */
  public function executeRedirect(sfWebRequest $request)
  {
    $newRoute = $request->getParameter('new_route');
    $this->forward404Unless($newRoute);

    if (strpos($newRoute, '@') !== 0)
    {
      $newRoute = '@'.$newRoute;
    }

    $this->redirect($newRoute, 301);
  }
}
