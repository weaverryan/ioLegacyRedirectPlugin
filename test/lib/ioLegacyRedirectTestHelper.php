<?php

/**
 * Helper function that can be used in your project tests to do a sanity
 * check on all of your redirects
 */
function test_all_legacy_urls(sfTestFunctional $browser)
{
  $legacyUrls = sfConfig::get('app_legacy_redirect_urls', array());
  
  foreach ($legacyUrls as $page)
  {
    $browser
      ->get($page['old_url'])

      ->with('request')->begin()
        ->isParameter('module', 'ioLegacyRedirect')
        ->isParameter('action', 'redirect')
      ->end()

      ->with('response')->begin()
        ->isStatusCode(301)
      ->end()
      
      ->with('response')->isRedirected()->followRedirect()
      
      // we don't care where it goes, just that it goes somewhere
      ->with('response')->begin()
        ->isStatusCode(200)
      ->end()
    ;
  }

}
