=== URL Shortener ===
Contributors: Gerald Yeo
Donate link: http://fusedthought.com/donate/
Tags: url-shortener, short-url, url, shorten, tinyurl, is.gd, su.pr, bit.ly, tr.im, short.ie, snipurl, cl.gs
Requires at least: 2.7
Tested up to: 2.8.5
Stable tag: 1.4

Integration of URL Shortening Services with WordPress. Allows generating of shorturl with various services upon post/page publishing. 

== Description ==

[URL Shortener](http://fusedthought.com/downloads/url-shortener-wordpress-plugin/ "URL Shortener") plugin integrates multiple URL Shortening service with your WordPress.org installation. Brings a similar functionality of WordPress.com's WP.me shortlinks feature but using 3rd party URL Shorteners.

Current supported services are: 

* tinyurl 
* is.gd 
* su.pr 
* bit.ly 
* tr.im
* short.ie 
* snipurl
* cl.gs

== Installation ==

1. Upload files to your `/wp-content/plugins/` directory (preserve sub-directory structure if applicable)
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To display/get the shorturl value in your templated, place '<?php echo fts_show_shorturl($post) ?>' in your template.


== Screenshots ==
1. post/page integration
1. plugin admin interface


== Changelog ==

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


