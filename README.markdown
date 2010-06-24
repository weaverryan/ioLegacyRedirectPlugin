ioLegacyRedirectPlugin
----------------------

Allows you to specify old legacy urls and the route to the new url. Any requests
to the old url will be redirected (via a 301 redirect) to the url of the
new route.

Installation
------------

### With git

    git submodule add git://github.com/weaverryan/ioLegacyRedirectPlugin.git plugins/ioLegacyRedirectPlugin
    git submodule init
    git submodule update

### With subversion

    svn propedit svn:externals plugins

In the editor that's displayed, add the following entry and then save

    ioLegacyRedirectPlugin https://svn.github.com/weaverryan/ioLegacyRedirectPlugin.git

Finally, update:

    svn up

### Setup

In your `config/ProjectConfiguration.class.php` file, make sure you have
the plugin enabled.

    $this->enablePlugins('ioLegacyRedirectPlugin');

Usage
-----

The usage of the plugin is somewhat limited, but very simple. Create a map
of your old urls to your new routes in `app.yml`:

all:
  legacy_redirect:
    urls:
      contact_us:
        old_url:   '/contact-us'
        new_route: '@contact'

When the url `/contact-us` is hit, it will redirect to the url represented
by the `contact` route using an SEO-friendly 301 redirect.

Testing
-------

A helper function is made available so that you can quickly test the sanity
of all of your legacy urls. This won't verify that each goes to the correct
location, but will verify that all legacy urls redirect to a real route:

    // test/functional/yourApp/yourTestName.php
    include(dirname(__FILE__).'/../../bootstrap/functional.php');
    include(sfConfig::get('sf_plugins_dir').'/ioLegacyRedirectPlugin/test/lib/ioLegacyRedirectTestHelper.php');
    
    $browser = new dailysTestFunctional(new sfBrowser());
    
    test_all_legacy_urls($browser);

