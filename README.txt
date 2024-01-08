=== Sponsors ===
Contributors: ibenic
Donate link: http://www.wpsimplesponsorships.com
Tags: post type, images, partners, sponsors
Requires at least: 3.1.0
Tested up to: 6.4.2
Requires PHP: 7.0
Stable tag: 3.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sponsors makes it easy to add your sponsors and partners to your WordPress website.

== Description ==

Ever had to add a bunch of images with links on them for your event/company partners?
With Sponsors, you won't have to use a text widget for that anymore. The companies and people that support you, your company or your event now get a separate place in the dashboar where you can add a link and an image for each of them. Then you add the Sponsors widget to the sidebar of your choosing and the linked images will show up there.

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
* slider_image (full|default, default: full) - if full, the image will take full width
* style (list|grid|slider, default: list)
* order (ASC|DESC, default: ASC )
* orderby (menu_order|post_title|..., default: menu_order)
* adaptiveheight (1|0, default: 1) - available for style=slider
* autoplay (1|0, default: 1) - available for style=slider
* autoplayspeed (number, default: 3000)  - available for style=slider
* arrows (1|0, default: 1 ) - available for style=slider
* centermode (1|0, default: 0 ) - available for style=slider
* dots (1|0, default: 0 ) - available for style=slider
* infinite (1|0, default: 1 ) - available for style=slider
* slidestoshow (number, default: 1 ) - available for style=slider
* slidestoscroll (number, default: 1 ) - available for style=slider
* variablewidth (number, default: 0 ) - available for style=slider
* breakpoints (string) - available for style=slider

When with_categories is used, it will show sponsors under their appropriate categories.
The attribute size is used to define the size of the columns. More style updates will come in future versions.

If you want to use the slider and show different number of images on different screen sizes, you can use the **breakpoints** attribute.
For example, we want to show 3 images on large screens and slide 3 images on click. Then on 640px view, we want to show 2 and slide 2 images. And on 480px view, we want only 1 image and 1 image to slide.
We would use the shortcode like this:

[sponsors style=slider arrows=1 image_size=full slidestoscroll=3 slidestoshow=3 breakpoints=480;1;1|640;2;2]

The attribute **breakpoints** uses format "screen_px;images_to_show;images_to_slide". Then for multiple breakpoints, we separate them by "|".
In the above example we have separated 2 breakpoints 480px and 640px.
For 480px, we set 1 for images to show and 1 for images to slide.
For 640px, we set 2 for images to show and 2 for images to slide.

** Form **
This shortcode will display a form so potential sponsors can submit their information.
Each Sponsor entered with that form will become a Draft so they won't be displayed immediately.
You can publish them, or send them an email to get their logo as well.

Shortcode [sponsors_acquisition_form] will allow it. Fields that are used here are:

* Name
* Email (so you can email them about their submission)
* Description
* Link

Available attributes:

- fields - separate field keys with comma,
- fields_labels - separate field labels with comma,
- button - Button text.

Each defined field will be a textarea. For example, you can add more fields like this:

[sponsors_acquisition_form fields=about,what fields_labels=About,What?]

== Planned Features ==

Here are some of the features planned for future versions:

* Category ordering
* Documentation Page
* Front optimizations
* Elementor Blocks

== Simple Sponsorships ==

This plugin is fully compatible with [Simple Sponsorships](https://wordpress.org/plugins/simple-sponsorships/).

If you want to accept payments from sponsors on your site and have a way to define different packages and automate the whole process, try Simple Sponsorships.

== Installation ==

1. Upload `wp-sponsors` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your sponsors under the sponsors section with links and logo's
4. Add the widget to your sidebar

== Screenshots ==
1. After you activate the plugin, a new content type will become available on the your WordPress admin panel. Here you can add a link, a description and an image for each Sponsor.
2. Add the widget to one or more sidebars and the images of your sponsors will show up there. Choose from which category you want to display sponsors (or select all), to show or hide images and the description

== Changelog ==

= 3.5.1 - 2024-01-08 =
* Security update

= 3.5.0 - 2021-05-14 =
* New: Shortcode attribute verticalcenter for slider to define if we need to center the images/content vertically. On by default.
* New: Block option same as shortcode verticalcenter added.
* Fix: Widget image size would show a warning in logs if not defined.

= 3.4.0 - 2020-09-06 =
* New: Shortcode attribute slider_image for slider to define how we show images. Options are full and default.
* New: Sponsor Acquisition form now sends email to the site owner.
* New: Block option same as shortcode slider_image added.

= 3.3.0 - 2020-02-27 =
* New: Shortcode attribute variablewidth for slider so the slides width will be the same as the image.
* New: Shortcode attribute breakpoints added to create breakpoints for showing different number of images. Check the shortcode attributes documentation.
* New: Documentation page in the admin area.
* Fix: CSS Slider fixes.
* Fix: Sponsors Block slider option would not always create the slider.

= 3.2.0 - 2019-11-05 =
* New: Slider layout for shortcode (style=slider)
* New: Slider layout for Sponsor Block
* Fix: Additional paragraphs in HTML in shortcode.
* Fix: Image size option is used in all layout options (Shortcode/Block/Widget).

= 3.1.1 - 2019-08-13 =
* Refactor: Each sponsor in shortcode has all their assigned categories.

= 3.1.0 - 2019-08-11 =
* Widget - Image size is now respected even in horizontal, although resized to 100px in height through CSS.
* Widget/Shortcode - Sponsors have category slugs applied as classes on each sponsor item.
* Sponsors Block - a block is available for Gutenberg Editor.
* Refactor: All assets placed under one single folder for better maintenance.
* Refactor: Title showing in shortcode even without link.

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
