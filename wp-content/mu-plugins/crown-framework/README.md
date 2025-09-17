# Crown WordPress Framework

The Crown Framework provides the underlying functionality for the repository of Crown plugins.

## Installation

It is recommended that the core Crown Framework plugin is installed in the **must use** plugins directory within WordPress, `wp-content/mu-plugins`, to prevent accidental deactivation/uninstallation. To include this plugin's functionality, you may create a proxy plugin file, such as `mu-crown-framework.php`, in the `mu-plugins` folder:

```
wp-content/
├── mu-plugins/
|   ├── crown-framework/
|   |   └── ...
|   └── mu-crown-framework.php
└── plugins/
    └── ...
```

The `mu-crown-framework.php` would simply include the framework loader as well as some relevant meta data:

```
<?php
/**
 * Plugin Name: Crown Framework
 * Plugin URI: http://www.jordancrown.com
 * Description: The Crown Framework extends the functionality of the WordPress core.
 * Version: 2.13.7
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Pulic License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// load framework
require_once(dirname(__FILE__).'/crown-framework/load.php');
```

## Developing Crown

### Running Gulp Tasks

The CSS of the framework is compiled from a set of SASS files within the `src/Resources/Public/css/scss` directory while the Javascript files in the `src/Resources/Public/js` directory are minified. Both of these operations can be done via Gulp using the included `gulpfile.js` file.

In the crown framework's directory from terminal, install all the required node modules:

```
$ npm install
```

To run the Gulp watch task for compiling assets:

```
$ gulp watch
```