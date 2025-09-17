# Changelog #

## 2.13.7 ##
* Enabling media filters for admin.
* Adding features from latest project.

## 2.13.6 ##
* Adding remote media URL filters for testing environments.

## 2.13.5 ##
* Fixing filter hook for SEO framework compatibility.
* Replacing curly braces for array index accessing.

## 2.13.4 ##
* Fixing issue with field tables used within field repeaters.

## 2.13.3 ##
* Fixing typo in changelog.
* Correcting flexbox grid overflow issue.

## 2.13.2 ##

* Search parent repeater entries for UI rule inputs if none found on the local scope.
* Updating crown fields CSS to use flexbox.
* Adding support for multiple option for select inputs.
* Adding support for sortable Select2 inputs.
* Adding support code editor textarea inputs using `mode` option.

## 2.13.1 ##

* Fixing input UI rule bug for repeater entry initialization.

## 2.13.0 ##

* Adding support for Select2 interface for select inputs.
* Adding support for input-controlled UI rules.
* Adding support for table fields.
* Adding support mid-list add repeater entry and repeater flex entry buttons.
* Adding support for optional repeater single entry titles.
* Adding support for `nav-top` class for field group sets.

## 2.12.0 ##

* Adding filter to prevent certain meta fields from saving to post's repeater entries.
* Fixing tweet parsing issue.
* Include Google API key to geocoding request URL.
* Fixing input default value issue.
* Wrapping color picker palette options.
* Other miscellaneous bug fixes.

## 2.11.8 ##

* Bugfix: Accurately detecting if default value needs to be used.
* Bugfix: Allowing default value for radio set inputs to be defined.

## 2.11.7 ##

* Adding hook to duplicate post repeater entries on post duplication (from plugin).

## 2.11.6 ##

* Bugfix: Updating nested repeater entry gallery inputs properly.

## 2.11.5 ##

* Adding ability to accept get field output callback function parameters relatively.

## 2.11.4 ##

* Bugfix: Stopping propogation on checkbox/radio set sorting start events.

## 2.11.3 ##

* Bugfix: Allowing LatLng objects to be passed into center property of map point objects.

## 2.11.2 ##

* Allowing map markers to be draggable, adding toggle to geo coordinates input class.

## 2.11.1 ##

* Tweaking flex repeater field dropdown styling to be more usable.

## 2.11.0 ##

* Adding radio image set input type support.
* Bugfix: CSS and JS fixes for optimizing SVG upload support.
* Bugfix: Allowing color inputs to be used in repeater fields.

## 2.10.4 ##

* Bugfix: Don't try to convert date input to time before saving if blank.

## 2.10.3 ##

* Fixing Google maps initialization procedure.

## 2.10.2 ##

* Adding check to make sure WordPress is installed before initializing Crown.

## 2.10.1 ##

* Commenting out termmeta database table creation function call, not needed for current versions of WordPress.

## 2.10.0 ##

* Adding user settings support.
* Adding widget support.

## 2.9.0 ##

* Transitioning to modular approach to Crown functionality through separate plugins.
* Allowing updating of existing repeater entries instead of replacing them on every save.
* Removing Google Maps API sensor parameter.
* Allowing maps to be initialized without automatically adding markers.
* Removing docs from repository.

## 2.8.0 ##

* Adding module for sorting taxonomy terms.

## 2.7.1 ##

* Fixing padding issues for single field group sets within new entry elements.

## 2.7.0 ##

* Adding headers to flex entries and allow collapsable functionality.

## 2.6.4 ##

* Switching to CSS Nano package for compressing CSS files.
* Bugfix: Explicitly overriding default value of inputs that may not be passing in values.

## 2.6.3 ##

* Bugfix: Fixing default date value.
* Bugfix: Setting default value of checkboxes to 0 to avoid confusion when querying database.

## 2.6.2 ##

* Bugfix: Error when using Google Maps API geocode method.

## 2.6.1 ##

* Adding documentation for menu item meta module class.
* Updating documentation in functions.php.
* Deprecating term meta functions.

## 2.6.0 ##

* Adding field group set class to support tabbed field group interfaces.
* Updating base checkox & radio input styles.
* Bugfix: Allow sortable radio buttons to be actually sortable.

## 2.5.1 ##

* Converting LESS to SASS for CSS assets.
* Including necessary package.json and gulfile.js files for compiling assets.

## 2.5.0 ##

* Adding radio and checkbox set input types.

## 2.4.1 ##

* Adding experimental support for custom menu item fields

## 2.4.0 ##

* Adding support for flexible repeater fields

## 2.3.2 ##

* Creating separate geocode data retrieval method for getting more info about the requested address
* Disabling viewing options for conditional UI meta boxes and forcing them to be shown/hidden based on conditions

## 2.3.1 ##

* Disabling date input auto-init
* Bugfix: Updating fielset border colors for admin pages
* Bugfix: Label font weight inconsistency
* Bugfix: Palette options initializing
* Bugfix: Make sure input is set before retreiving default value
* Bugfix: Adding js to clear out new taxonomy term form fields

## 2.3.0 ##

* Adding support for get output and save meta callbacks for fields
* Adding color input type

## 2.2.1 ##

* Switching date input to use datepicker UI
* Switching time input to use select element

## 2.2.0 ##

* Adding Zoho CRM API wrapper.

## 2.1.7 ##

* Bugfix: Support for gallery input fields within repeater fields.

## 2.1.6 ##

* Bugfix: Allow default values to be set within field groups inside of repeater fields.

## 2.1.5 ##

* Returning entry ID along with repeater entry meta data.

## 2.1.4 ##

* Bugfix: Fixing issue with nested repeater fields.

## 2.1.3 ##

* Bugfix: Unslashing data before saving admin page settings.

## 2.1.2 ##

* Bugfix: Correcting saving behavior for checkboxes with default values assigned.

## 2.1.1 ##

* Bugfix: Properly initialize HTML editor when dynamically creating rich text area inputs.

## 2.1.0 ##

* Adding Twitter and Facebook API wrappers.
* Adding conditional UI functionality to fields and meta boxes.
* Adding ability to assign custom class names to meta boxes.
* Adding autoinit option to Google Map config options.
* Bugfix: Adding check to see if Google Maps API has been set before including map element.

## 2.0.3 ##

* Adding gallery form input class.
* Adding ability to group select inputs' options into optgroups.
* Disabling zoom on scroll for geocoordinates input maps.

## 2.0.2 ##

* Adding `Crown\Api\GoogleMaps::getMap()` function to Google Maps API class.

## 2.0.1 ##

* Resolving issue with required inputs in form field repeaters.

## 2.0.0 ##

* Release of Crown Framework 2.0, completely rewritten from the ground up to be awesome!

## 1.0.0 ##

* Initial release of the Crown Framework.
