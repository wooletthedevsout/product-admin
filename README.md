# Woo Let The Devs Out | Product Admin Module

To be used either as a standalone module or library, or as part of the WLTDO framework, this module intends to automate and ease the process of customizing WC product edit pages.

Initially, classes will take care of everything as you add new tabs and panels to product meta within the edit pages. Additionally, we are developing classes to manage and alter existent tabs and fields.

# Install

The easier way of using this package is by requiring it using Composer.

# Usage

In the plugin's main file, use the classes and autoload them with Composer.

```php

use OnePedras\{Tabs, Panels};
require __DIR__ . '/vendor/autoload.php';

$tabs = new Tabs('New Tab', $fields);
```

The class Tabs needs two parameters: the first is the name (not the slug) of the new tab, and the second an array of fields to be added. The array admits any number of fields, each one of them as a new array.

```php
// Once the tab is created, we need to inject the panels dependency, using the method getPanel()

$tabs->getPanel();

// Also, a title can be added if you want so

$tabs->addTitle('The title');
```

## Ok, what about the fields?

Ohh... of course. As shown, the fields and firstly passed to the Tabs instance as an array. For this moment, we cover all field types with native support by Woocommerce: text, number, textarea, checkbox, select, radio (needs a CSS fix, as the WC native function is defective for the product edit area).

So, we need an array of arrays. Each element is a field, and for each of these, the first element will be the field type:

*** [{{FIELD TYPE}}, {{SLUG}}, {{LABEL}}, {{DESCRIPTION}}] ***

For the select type, an additional element (another array) will include the options to be added. The same happens for the radio field, although for this latter we just cut the description, as it generates a lot of bugs within the backend. So, for the SELECT field and the RADIO field, respectivelly, we need to register like this:

*** [{{FIELD TYPE}}, {{SLUG}}, {{LABEL}}, {{DESCRIPTION}}, {{ARRAY OF OPTIONS}}] ***
*** [{{FIELD TYPE}}, {{SLUG}}, {{LABEL}}, {{ARRAY OF OPTIONS}}] ***

Thus, imagine that we want two text fields, one checkbox, one select field and one radio, considering the previous code. The array to be passed would look like this:

```php
$forms = [
	[
		'text',
		'user_message', 
		'Cool Label', 
		'Description for the tooltip with question mark.'
	],
	[
		'text', 
		'capacity', 
		'Another Label', 
		'Description for the tooltip with question mark.'
	],
	[
		'checkbox', 
		'confirm', 
		'Confirmation', 
		'Description for the tooltip with question mark.'
	],
	[
		'select', 
		'choices', 
		'Select Title', 
		'Description for the tooltip with question mark.',
		[
			'Choice 1',
			'Choice 2',
			'Choice 3'
		]
	],
	[
		'radio', 
		'choices', 
		'Select Title',
		[
			'Choice 1',
			'Choice 2'
		]
	];
```

# FAQ

Well, this is one of the first libraries and modules for the new Woo Let The Devs Out framework. So I imagine you guys have a lot of questions. Let's try to answer some of them.

### Do I need to use hooks or further implementation in order to save the meta of these new fields?

No, the Panels class is already equipped with the methods to do so.

### What about validating fields?

Honestly? We are working at... we are not pretty satisfied with WC's native validation, so we should eventually come up with something more sophisticated.

### Can we expect new field type (especially those not covered by the WC native API, like datetime, image, etc)?

Definitely, the point with the WLTDO framework is to provide, ultimately, an easy and OO way of extending Woocommerce. Although some implementations and extensions for WC are really well-developed, like those for payment gateways, when developing complex integrations and entire packages, they require us to be really repetitive.