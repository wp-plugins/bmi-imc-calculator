=== BMI / IMC Calculator ===
Contributors: solokco
Donate link: http://estoesweb.com/
Tags: BMI, Calculator, IMC, Health, weight
Requires at least: 4.0
Tested up to: 4.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple calculator to show your users BMI (Body Mass Index)

== Description ==

= ENGLISH =
This is a basic calculator that displays the users BMI (Body Mass Index) depending on their Height and Weight

You can select to display the input options as
* Metric (Centimeters and Kilograms)
*Imperial (Inches and Pounds)

It's easy to configure different options from the wordpress panel

= SPANISH =
Esta es una calculadora sencilla que muestra el IMC (Indice de Masa Corporal) de los usuarios dependiendo de su Peso y Altura

Puedes seleccionar mostrar el formulario en 
*Sistema métrico (Centímetros y Kilogramos)
*Sistema imperial (Pulgadas y Libras)

Fácil de configurar desde el panel de wordpress

== Installation ==

1. In admin panel go to Plugins / Add new plugin
1. Search and Upload 'esw_imc_calculator.zip' file
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Widgets in your Wordpress menu
1. Add the widget to the sidebar you want


== Frequently Asked Questions ==

= What formula do you use to calculate the BMI / IMC =

Is the same formula you can find in [Wikipedia](http://en.wikipedia.org/wiki/Body_mass_index "Wikipedia")

= What languages are avalible? =

This plugin comes by default with:
*spanish
*english

but you can add new languages in the "languages" folder

= How to use the Shortcode? =
Add the following text in your text block: [bmi_calculator]

= How to use the Shortcode with atts? =
Add the following text in your text block: [bmi_calculator hide_table=true hide_styles=true system_type="imperial" section_title="My personal title" ]


= Shortcode Attributes  =
	*hide_table (true / false)
    *hide_header (true / false)
    *hide_styles (true / false)
    *hide_footer (true / false)
    *system_type  (metric / imperial)
    *section_title (string)



== Screenshots ==

1. A simple and elegant form to input the users data
2. Displays the user result with a table of the different values
3. If the users BMI / IMC is right, the color shows green
4. Easy to configure panel inside wordpress admin

== Changelog ==

= 1.1 =
* Added shortcode function - [bmi_calculator]

= 1.0.1 =
* Replaced folder assets with includes
* Added icons for Wordpress repository

= 1.0 =
* First release of the plugin.

== Upgrade Notice ==

= 1.1 =
* Added shortcode function for extensive use of the plugin

= 1.0.1 =
* Fixed folder structure for best results with Wordpress and added new images for the Wordpress repository

= 1.0 =
* Initial development of the plugin