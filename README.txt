=== Plugin Name ===
Contributors: janhenckens
Donate link: http://studioespresso.co/donate/
Tags: post type, images, partners, sponsors
Requires at least: 3.0.1
Tested up to: 4.7.5
Stable tag: 2.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sponsors makes it easy to add your sponsors and partners to your WordPress website.

== Description ==

Ever had to add a bunch of images with links on them for your event/company partners? With Sponsors, you won't have to use a text widget for that anymore. The companies and people that support you, your company or your event now get a separate place in the dashboar where you can add a link and an image for each of them. Then you add the Sponsors widget to the sidebar of your choosing and the linked images will show up there.

== Installation ==

1. Upload `wp-sponsors` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your sponsors under the sponsors section with links and logo's
4. Add the widget to your sidebar


== Screenshots ==
1. After you activate the plugin, a new content type will become available on the your WordPress admin panel. Here you can add a link, a description and an image for each Sponsor.
2. Add the widget to one or more sidebars and the images of your sponsors will show up there. Choose from which category you want to display sponsors (or select all), to show or hide images and the description

== Shortcode ==

=== Shortcode ===

The shortcode [sponsors] takes the following options:
* images (yes|no, default: yes)
* description (yes|no, default: no)
* max (number, default: none, showing all entries)
* title (yes|no, default: no)
* category (category-slug, default: all)
* size (small|medium|large|full, default: medium)
* style (list|grid, default: list)

== Changelog ==

= 2.3.1 =
* Fixed a critical issue where we assumed your table prefix was 'wp_'
* Fixed the max settings in the shortcode

= 2.3.0 =
* Fixed equal height grid layout for the shortcode
* Added a per-sponsor setting to open the sponsor link in a new window

= 2.2.3 =
* Fixes an issue where the shortcode would take over the current page's post type and edit link.

= 2.2.2 =
* Changed how sponsors are links in the shortcode. No using the no-images option, the title will be linked and the description won't be. With images, the image will link and the title won't.

= 2.2.1 =
* Bugfix

= 2.2 =
* Added translations for fr_BE and fr_FR
* Added a filter called "sponsors_widget_styling" to add a css class to each sponsor item from your theme

= 2.1 =
* Added number of entries and title options to the shortcode
* Added number of entries option to the widget
* Added orderby title and random options to the widget

= 2.0.3 =
* Fixed a problem where the sponsor link wouldn't be shown when using no images in the shortcode

= 2.0.2 =
* The "no images" options in the shortcode now actually works
* Improved styling of the widget title across themes
* Updated translations for nl_NL and nl_BE

= 2.0.1 =
* Fixes a PHP notice when installing the plugin for the first time

= 2.0.0 =
* The plugin now uses the featured image field to save the sponsor's logo
* Improved shortcode code and added "grid" style option
* Added debug option to shortcode to better support layout issues

= 1.9.1 =
* Bugfix in the nofollow feature

= 1.9.0 =
* Improved sponsor description saving
* Added default rel="nofollow" for sponsor links
* Added support and donate links to plugin description

= 1.8.5 =
* In the shortcode, items are now sorted by the menu_order by default.

= 1.8.4 =
* PHP 7 Compatibilty
* Fixes a bug with the category selection in the shortcode, props to joachimjusth

= 1.8.3 =
* One last fix to the category selection in the widget, this should have all cases possible now.

= 1.8.2 =
* Fixes a bug caused in 1.8.1 where widgets that selected all sponsor categories wouldn't display any entries.

= 1.8.1 =
* Fixes a problem with category filtering on the widget

= 1.8.0 =
* Added "show sponsor title" option to the widget, not checked by default
* Updated the translations files with the latest strings and included an updatedd nl_NL translation

More information of older versions can be found in changelog.txt
