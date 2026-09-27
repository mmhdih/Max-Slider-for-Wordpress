=== Max Slider ===
Contributors: mmhdih
Tags: slider, carousel, banner, rtl, elementor
Requires at least: 5.8
Tested up to: 7.2
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight, dependency-free image sliders with separate mobile images, placed anywhere with a shortcode. RTL ready.

== Description ==

Build as many independent sliders as you need, each with its own aspect ratio, speed and style, and show them with a shortcode in any page, post, widget or Elementor "Shortcode" widget.

* Multiple sliders (placements), one slide can belong to several sliders
* Separate desktop and mobile image and aspect ratio
* Optional link per slide
* Boxed, wide (1440px) and full-width layouts
* Slide and fade effects, autoplay, arrows, dots, shadow, corner radius, spacing and accent color
* JPG, PNG, WEBP and animated GIF
* Touch swipe, keyboard control, pause on hover and hidden tab
* Automatic RTL / LTR support
* No jQuery on the front end, CSS + JS under 8 KB, script loaded only where a slider is shown
* Persian (fa_IR) translation included

Full guide with screenshots: https://github.com/mmhdih/Max-Slider-for-Wordpress

== Installation ==

1. Upload `max-slider.zip` in Plugins → Add New → Upload Plugin and activate it.
2. Go to Sliders → Manage sliders and create a slider.
3. Go to Sliders → Add slide, set the slide image and tick the slider it belongs to.
4. Put `[sp_slider id="your-slider-slug"]` where the slider should appear.

== Frequently Asked Questions ==

= Which shortcodes are available? =

`[sp_slider id="slug"]`, its alias `[max_slider id="slug"]`, and `[sp_home_slider]` for the slider with the slug `home`.

= The slider does not show up =

Check the slug in the shortcode, and make sure the slides are published, have a slide image and are assigned to the slider.

= I used the "Sepanta Slider" plugin or code snippet before =

Max Slider uses the same data and shortcode. Deactivate the old plugin (or remove the snippet) and activate Max Slider; everything keeps working.

== Changelog ==

= 1.0.0 =
* First public release, based on the Sepanta Pet multi-slider.
* New: accent color setting, keyboard navigation, pause when the tab is hidden or a control has focus.
* New: automatic RTL / LTR direction (arrows, swipe and keyboard follow the page direction).
* New: `[max_slider]` shortcode alias and "Manage sliders" link on the Plugins screen.
* New: translation ready with Persian translation; English strings for other sites.
* Improved: CSS/JS moved to cached files; the script loads only on pages with a slider.
* Improved: settings are validated against allowed values; capability checks on save.
* Improved: styles protected against theme button styles; fade effect without layout jumps.
* Improved: warning when the old snippet/plugin is still active; slide fields hidden from the Custom Fields box.
