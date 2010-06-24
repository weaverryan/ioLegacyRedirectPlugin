<?php

require_once dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser->info('1 - Goto a legacy url and see that it redirects')
  ->get('/contact-us')
  
  ->with('request')->begin()
    ->isParameter('module', 'ioLegacyRedirect')
    ->isParameter('action', 'redirect')
    ->isParameter('new_route', '@contact')
  ->end()
  
  ->with('response')->begin()
    ->isStatusCode(301)
  ->end()
  
  ->with('response')->isRedirected()->followRedirect()
  
  ->with('request')->begin()
    ->isParameter('module', 'main')
    ->isParameter('action', 'contact')
  ->end()

  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;

$browser->info('2 - do the same process, but with a config value referencing the new route with an "@"')
  ->get('/contact-us2')
  
  ->with('request')->begin()
    ->isParameter('module', 'ioLegacyRedirect')
    ->isParameter('action', 'redirect')
    ->isParameter('new_route', 'contact')
  ->end()
  
  ->with('response')->begin()
    ->isStatusCode(301)
  ->end()
  
  ->with('response')->isRedirected()->followRedirect()
  
  ->with('request')->begin()
    ->isParameter('module', 'main')
    ->isParameter('action', 'contact')
  ->end()

  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;
