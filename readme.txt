=== URL Shortener ===
Contributors: geraldyeo
Donate link: http://fusedthought.com/donate/
Tags: url-shortener, short-url, url, shorten, shortener, tinyurl, is.gd, su.pr, bit.ly, tr.im, short.ie, snipurl, snurl, cl.gs, short.to, ping.fm, chilp.it, smoosh, smsh.me, u.nu, unfake.it, awe.sm, social, tweet, twitter, goo.gl
Requires at least: 2.7
Tested up to: 2.9
Stable tag: 1.7

Use your own URL Shortener or integrate 3rd Party Services with WordPress. Allows generating of shorturl with various services upon post/page publishing. 

== Description ==

[URL Shortener](http://fusedthought.com/downloads/url-shortener-wordpress-plugin/ "URL Shortener") plugin allows you to create your own short url using the WordPress Post ID (for eg: http://yoursite/POST-ID ). It provides two method of redirection, namely, wp_rewrite redirect and template_redirection (template redirect).

It also integrates multiple URL Shortening service with your WordPress.org installation bringing a similar functionality to that of WordPress.com's WP.me shortlinks feature but using 3rd party URL Shorteners. 

To show the generated links in your template just include this function within the loop:

`<?php fts_show_shorturl($post); ?>`


As of Version 1.5, I've added an on-demand shortening function for use in the templates:

`<?php fts_shorturl('http://www.google.com', 'supr'); ?>`


Version 1.5 also brings about an updated administration options page.


Version 1.7 now enables the inclusion of a addon module which will enable URL Shortening Services which are undergoing testing but not official supported under this main plugin. For more information, visit the [URL Shortener Addon Module information page](http://fusedthought.com/downloads/addon-module-for-url-shortener-wordpress-plugin/ "URL Shortener Addon Module information page")  

**Current supported services are:**

* tinyurl 
* is.gd 
* su.pr 
* bit.ly 
* tr.im
* short.ie 
* snipurl (aka Snurl / Snipr / Sn.im)
* cl.gs
* short.to
* ping.fm
* chilp.it
* smsh (aka sm00sh)
* u.nu
* unfake.it 
* awe.sm


**Notes on Awe.sm usage:**

*  Custom domain can be configured in your Awe.sm account on the awe.sm website.


**Addon Module Service list**

*  goo.gl (Google URL Shortener)


**Future Versions:**

*  I am still looking into creating a URL Management page to manage all the generated URLs within the site.
*  Twitter and Facebook posting integration?
*  More services can be added upon request.

**Support via:**

*  http://wordpress.org/tags/url-shortener
*  Contact me via my website.


== Installation ==

1. Upload files to your `/wp-content/plugins/` directory (preserve sub-directory structure if applicable)
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To display/get the shorturl value in your templated, place '<?php echo fts_show_shorturl($post) ?>' in your template.


== Screenshots ==
1. post/page integration(ver 1.4)
1. plugin admin interface (ver 1.4)
1. plugin admin interface (ver 1.5)


== Changelog ==

= 1.7 =
* Included an Addon module option
* Addon functions for additional service display
* Directory structure cleanup

= 1.6.3 =
* WordPress 2.9 Compatibility check.
* If WordPress.com stats plugin enabled, "Show Short URL" button in edit page beside "view" is removed.

= 1.6.2 =
* Added prefix choosing support for Sn.im / Snipr / Snipurl / Snurl

= 1.6.1 =
* Bugfix: future/scheduled posts not generating Short URL.

= 1.6 =
* Added support for Awe.sm (user request)
* Changed URL Generation method hook for future/scheduled posts

= 1.5.2 =
* Bugfix: Pingfm key not saving.

= 1.5.1 =
* Bugfix: Short URL generated was the same as post URL

= 1.5 =
* Added on-demand shortening function: fts_shorturl()
* Added supported for ping.fm, chilp.it, short.to, sm00sh, u.nu, unfake.it  
* Added personal shortening service using post id (http://yoursite/POST-ID)
* Added Prefix option for personal shortening service (http://yoursite/prefix/POST-ID)
* Added template redirection and WP_Rewrite redirection methods
* Updated administration options page

= 1.4 =
* First Public Release
* Added simple validation to options page

= 1.3 =
* Added support for snipurl, cl.gs, Short.ie

= 1.2 =
* Added support for su.pr

= 1.1 =	
* Added support for bit.ly, tr.im
* Added "Remove buttons" in post/page edit.
* Added option for automatic shorturl generation.
* Changed Custom Field name from fts_shorturl to shorturl

= 1.0 =
* Initial Private release.
* supports TinyURL, is.gd


