=== Plugin Name ===
Contributors: janhenckens
Donate link: http://onedge.be/donate/
Tags: post type, images, partners, sponsors
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP-Sponsors gives your sponsors or partners a separate home where can add a link and a logo.

== Description ==

WP-Sponsors gives your sponsors or partners a separate home where can add a link and a logo.

Ever had to add a bunch of images with links on them for your event/company partners? With Sponsors, you won't have to use a text widget for that anymore. The companies and people that support you, your company or your event now get a separate place where you can add a link and an image for each of them. Then you add the Sponsors widget to the sidebar of your choosing and the linked images will show up there.

= Upcoming features: =
* Taxonomy - divide your sponsors up in categories and choose which ones to display in which widget
* Weight - Give your sponsors a weight (in their category) to determine how they should be sorted in the widget

== Installation ==

1. Upload `wp-sponsors` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your sponsors under the sponsors section with links and logo's
4. Add the widget to your sidebar

== Screenshots ==

== Screenshots ==
1. After you activate the plugin, a new content type will become available on the your WordPress admin panel. Here you can add a link and an image for each Sponsor.
2. Add the widget to one or more sidebars and the images of your sponsors will show up there.

== Changelog ==

= 1.2 =
* Added shortcode support. Use the shortcode [sponsors] with these options: images="yes/no", size="small/medium/large/full". Defaults to showing images at 25% width of the current container.
* Added initial translations for nl_NL and include updated POT file to others can translate the plugin if needed.

= 1.1 =
* Added categories and filter-on-category option in widgets

= 1.0.3=
* Fixed a bug that caused only 5 items to display, now all items are shown

= 1.0.2 =
* Add a title to the sponsors widget

= 1.0.1 =
* Fixed a PHP error when adding the widget for the first time
* The "Show images" checkbox in the widget actually works now

= 1.0 =
* Custom post type for Sponsors
* Widget to display all sponsors (currenty sorted oldest entry first)
