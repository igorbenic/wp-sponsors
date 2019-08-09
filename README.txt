=== Sponsors ===
Contributors: ibenic
Donate link: http://www.wpsimplesponsorships.com
Tags: post type, images, partners, sponsors
Requires at least: 3.1.0
Tested up to: 5.2.2
Requires PHP: 7.0
Stable tag: 3.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sponsors makes it easy to add your sponsors and partners to your WordPress website.

== Description ==

Ever had to add a bunch of images with links on them for your event/company partners?
With Sponsors, you won't have to use a text widget for that anymore. The companies and people that support you, your company or your event now get a separate place in the dashboar where you can add a link and an image for each of them. Then you add the Sponsors widget to the sidebar of your choosing and the linked images will show up there.

== Installation ==

1. Upload `wp-sponsors` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your sponsors under the sponsors section with links and logo's
4. Add the widget to your sidebar


== Screenshots ==
1. After you activate the plugin, a new content type will become available on the your WordPress admin panel. Here you can add a link, a description and an image for each Sponsor.
2. Add the widget to one or more sidebars and the images of your sponsors will show up there. Choose from which category you want to display sponsors (or select all), to show or hide images and the description

== Shortcodes ==

** Sponsors **
The shortcode [sponsors] takes the following options:
* images (yes|no, default: yes)
* image_size (medium|full|thumbnail|large|[any registered image size], default: medium)
* description (yes|no, default: no)
* max (number, default: none, showing all entries)
* title (yes|no, default: no)
* category (category-slug, default: all)
* with_categories (yes|no, default: no )
* category_title ( HTML tag for category title, default: h3)
* size (small|medium|large|full, default: medium)
* style (list|grid, default: list)
* order (ASC|DESC, default: ASC )
* orderby (menu_order|post_title|..., default: menu_order)

When with_categories is used, it will show sponsors under their appropriate categories.
The attribute size is used to define the size of the columns. More style updates will come in future versions.

** Form **
This shortcode will display a form so potential sponsors can submit their information.
Each Sponsor entered with that form will become a Draft so they won't be displayed immediately.
You can publish them, or send them an email to get their logo as well.

Shortcode [sponsors_acquisition_form] will allow it. Fields that are used here are:

* Name
* Email (so you can email them about their submission)
* Description
* Link

== Planned Features ==

Here are some of the features planned for future versions:

* Form Block - for the new WordPress block editor
* Sponsors Block - for the new WordPress block editor
* Category ordering
* Documentation Page
* Front optimizations
* Elementor Blocks

== Changelog ==

= 3.1.0 - 2019-08-11 =
* Widget - Image size is now respected even in horizontal, although resized to 100px in height through CSS.
* Widget/Shortcode - Sponsors have category slugs applied as classes on each sponsor item.
* Sponsors Block - a block is available for Gutenberg Editor

= 3.0.1 - 2019-07-16 =
* Widget was showing all sponsors instead of the number of sponsors that was entered.

= 3.0.0 =
* Big Code refactor.
* Refactor: URL is stored under _website. Backwards compatibility is available.
* Refactor: Description is stored under the regular content so we don't waste the database space.
* Refactor: Post Type has changed from 'sponsor' to 'sponsors'.
* Refactor: CSS for horizontal widget display has been enabled.
* New: Image sizes can be defined in shortcode and in widget.
* New: Sponsors can be display under appropriate categories in shortcode.
* New: Sponsor Acquisition Form shortcode [sponsors_acquisition_form] for front end information submission.
* New: Simple Sponsorships compatibility.

= 2.5.1 =
* Fixed a PHP 7.2 deprecation error

= 2.5.0 =
* Fixed a small error and the plugin now works with Gutenburg!

= 2.4.1 =
* Fixed php errors when using the shortcode without any options


More information of older versions can be found in changelog.txt
