=== Tavoos Image Carousel ===
Contributors: mmhdih
Tags: slider, carousel, banner, rtl, image slider
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight, dependency-free image sliders with separate mobile images, placed anywhere with a shortcode. RTL ready.

== Description ==

Build as many independent sliders as you need, each with its own aspect ratio, speed and style, and show them with a shortcode in any page, post, widget or page builder (Elementor "Shortcode" widget, Gutenberg "Shortcode" block, …).

* Multiple sliders (placements); one slide can belong to several sliders
* Separate desktop and mobile image and aspect ratio
* Optional link per slide
* Boxed, wide (1440px) and full-width layouts
* Slide and fade effects, autoplay, arrows, dots, shadow, corner radius, spacing and accent color
* JPG, PNG, WEBP and animated GIF
* Touch swipe, keyboard control, pause on hover and when the tab is hidden
* Automatic RTL / LTR support
* No jQuery on the front end; CSS + JS under 8 KB, loaded only on pages that show a slider
* Translation ready

Designed by Mahdi Habibi | Tavoos Web — https://tavoosweb.ir/

Full guide with screenshots: https://tavoosweb.ir/free-wordpress-plugins/

== Installation ==

1. Upload the plugin in Plugins → Add New → Upload Plugin (or install it from the plugin directory) and activate it.
2. Go to Sliders → Manage sliders and create a slider.
3. Go to Sliders → Add slide, set the slide image and tick the slider it belongs to.
4. Put `[tavoos_slider id="your-slider-slug"]` where the slider should appear. The code of every slider is shown in the "Display code" column.

== Frequently Asked Questions ==

= The slider does not show up =

Check the slug in the shortcode, and make sure the slides are published, have a slide image and are assigned to the slider.

= How do I change the look with CSS? =

Main classes: `.tavoos-slider`, `.tavoos-slide`, `.tavoos-slider__nav`, `.tavoos-slider__dots`, with the modifiers `tavoos-slider--boxed|wide|full` and `tavoos-slider--slide|fade`. CSS variables: `--tavoos-radius`, `--tavoos-gap`, `--tavoos-accent`, `--tavoos-rd` (desktop ratio) and `--tavoos-rm` (mobile ratio).

= The slider is added later with AJAX and does not move =

Call `window.tavoosSliderInit()` after the new content is inserted.

= I used version 1.x of this plugin or the Sepanta Slider plugin/snippet before =

Deactivate the old plugin (or remove the snippet) and activate Tavoos Image Carousel. Your sliders, slides and settings are moved over automatically, and the old `[sp_slider]` shortcodes in your pages keep working.

== Screenshots ==

1. Creating a slider — every slider shows its display code.
2. Slider settings.
3. Editing a slide: link, mobile image, slider and order.
4. All slides with image, slider and order.
5. The slider on the front end.
6. The slider on a phone with its mobile image.

== Changelog ==

= 2.1.0 =
* Renamed to Tavoos Image Carousel (slug and text domain `tavoos-image-carousel`). Sliders, settings and the `[tavoos_slider]` shortcode are unchanged.
* Translations are now delivered through translate.wordpress.org.

= 2.0.0 =
* New unique prefix for all code and data.
* All code, data and CSS names now use a unique prefix; the shortcode is `[tavoos_slider id="…"]`.
* Data of version 1.x / Sepanta Slider is migrated automatically; old shortcodes keep working on migrated sites.
* The stylesheet and script only load on pages that show a slider; the script is deferred.
* Nonce check when saving slider settings.

= 1.0.1 =
* Added designer credit (Mahdi Habibi | Tavoos Web) on the Plugins screen.

= 1.0.0 =
* First public release, based on the Sepanta Pet multi-slider.

== Upgrade Notice ==

= 2.1.0 =
New plugin name. If an earlier copy is installed in another folder, deactivate it before activating this one; your sliders are kept.

= 2.0.0 =
New name and prefix. Existing sliders are migrated automatically; deactivate the old plugin after installing this one.
