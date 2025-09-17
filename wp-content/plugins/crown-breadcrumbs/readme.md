# Crown Breadcrumbs

This WordPress plugin provides a function for generating site breadcrumbs to be called from your site's theme. Breadcrumb title override fields are automatically added to applicable post and term editors within the admin.



## Generating Breadcrumbs

To get the list breadcrumb links, call the `CrownBreadcrumbs` class' method `getBreadcrumbs()`:

```
$breadcrumbs = class_exists('CrownBreadcrumbs') ? CrownBreadcrumbs::getBreadcrumbs() : '';
```

You may optionally pass in a parameter to quickly modify the separator used between breadcrumb links:

```
$breadcrumbs = class_exists('CrownBreadcrumbs') ? CrownBreadcrumbs::getBreadcrumbs(' > ') : '';
```



## Filters

An assortment of filter hooks are available for extending/modifying the breadcrumb format.

---

### crown_breadcrumb_settings_post_types

Filter the post types to which the breadcrumb settings fields are added to in the post editor.

#### Parameters
* **`$applicablePostTypes`** - `array` The automatically-determined default set of post types to add settings to.

#### Return
`array` The modified set of post types to add settings to.

---

### crown_breadcrumb_settings_taxonomies

Filter the taxonomies to which the breadcrumb settings fields are added to in the term editor.

#### Parameters
* **`$applicableTaxonomies`** - `array` The automatically-determined default set of taxonomies to add settings to.

#### Return
`array` The modified set of taxonomies to add settings to.

---

### crown_breadcrumb

Filter the output of a single breadcrumb's HTML.

#### Parameters
* **`$output`** - `string` The default breadcrumb HTML.
* **`$link`** - `string` The breadcrumb's link element.
* **`$last`** - `bool` Indicator for if the breadcrumb is the last in list.

#### Return
`string` The modified breadcrumb HTML.

---

### crown_breadcrumbs

Filter the output of the breadcrumbs' HTML.

#### Parameters
* **`$breadcrumbs`** - `string` The default breadcrumbs HTML.
* **`$crumbs`** - `array` The individual breadcrumbs of the list.
* **`$sep`** - `string` The separator set to be used between each breadcrumb.
* **`$links`** - `string` The individual links to be included in the breadcrumb.
* **`$items`** - `string` The individual item data to be included in the breadcrumb.

#### Return
`string` The modified breadcrumbs HTML.

---

### crown_breadcrumb_items

Filter the item data to be used for generating the breadcrumb.

#### Parameters
* **`$items`** - `array` The default items to be included in the breadcrumbs.

#### Return
`array` The modified list of breadcrumb item data.

Each element of the return set of items is expected to be an array of one of the following formats:

* `array('p' => 42)` - A single post.
* `array('pt_archive' => 'staff')` - A post type's archive page.
* `array('tax' => 'category', 'term' => 164)` - A taxonomy term's archive page.
* `array('year' => '2016')` - A year's archive page.
* `array('year' => '2016', 'month' => '06')` - A month's archive page.
* `array('year' => '2016', 'month' => '06', 'day' => '16')` - A day's archive page.
* `array('author' => 6)` - An author's archive page.
* `array('page' => 3)` - An indicator for the page of a multi-page index.
* `array('url' => 'http://site.com/custom/link/', 'text' => 'Custom Link')` - The URL and text of a custom link.
* `array('text' => 'Custom Item')` - The text of a custom item (non-linking).

Optionally, the `url` and `text` key smay be defined for any of these formats to override what would be their default values when generating the breadcrumb HTML.

---

### crown_breadcrumb_link_url

Filter the URL to be used for a single breadcrumb link.

#### Parameters
* **`$url`** - `string` The default link URL.
* **`$item`** - `array` The item data for the link.
* **`$last`** - `bool` Indicator for if the breadcrumb is the last in list.

#### Return
`string` The modified link URL.

---

### crown_breadcrumb_link_text

Filter the text to be used for a single breadcrumb link.

#### Parameters
* **`$text`** - `string` The default link text.
* **`$item`** - `array` The item data for the link.
* **`$last`** - `bool` Indicator for if the breadcrumb is the last in list.

#### Return
`string` The modified link text.

---

### crown_breadcrumb_item_link

Filter the generated link HTML for a single breadcrumb.

#### Parameters
* **`$link`** - `string` The default link HTML.
* **`$url`** - `string` The default link url.
* **`$text`** - `array` The default link text.
* **`$item`** - `array` The item data for the link.
* **`$last`** - `bool` Indicator for if the breadcrumb is the last in list.

#### Return
`string` The modified breadcrumb link HTML.