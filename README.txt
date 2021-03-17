=== Date Time Field Add-On for Gravity Form ===
Contributors: awais300
Tags: GF, Gravity Form, datetime, date, time, addon
Requires at least: 4.0
Tested up to: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A date-time add-on for Gravity Forms with custom date time format.

== Description ==
A date-time add-on for Gravity Forms with custom date time format:

- This plugin will add new type of field under `Advanced Fields` as `Date-Time`. 
- Simply drag `Date-Time` field into the form.
- You can also add custom date time format under `General` tab. 
- The date time format pattern must follow moment.js tokens. Click [here](https://momentjs.com/docs/#/parsing/string-format/) to view moment.js date and time tokens.


== Translations included ==

* English
* Français (French)

== Installation ==

1. Upload and unzip `gf-datetime-field-add-on.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.2.0 =
* Add a filter hook `gf_awp_datetimepicker_script` to allow users to override JavaScript/jQuery for date-time picker.

= 1.0.1 =
* Fixed date-time picker loading after a Gravity Form is submitted via AJAX

= 1.0 =
* Added a Date Time field for Gravity form
* Added an option to add custom date time format
