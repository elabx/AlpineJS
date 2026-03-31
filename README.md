Adds alpinejs as a module in the ProcessWire admin.

Integrates [Alpine.js](https://alpinejs.dev/) locally into the ProcessWire Admin interface.

## Features

- **Local Hosting**: Downloads Alpine.js core and plugins from unpkg.com to your server for local serving.
- **Admin Integration**: Automatically loads Alpine.js in the ProcessWire Admin backend.
- **Plugin Support**: Easily enable official Alpine.js plugins (Mask, Intersect, Persist, Focus, Collapse, Morph, History).
- **1-Click Updates**: Check for updates and download the latest version directly from the module configuration.

## Requirements

- ProcessWire `3.0` or newer
- PHP `7.3` or newer

## Installation

Install the module from the [modules directory](https://modules.processwire.com/modules/) or with Composer:

```
composer require elabx/processwire-alpinejs
```

## Setup

After installing, you need to configure where Alpine.js is loaded from. There are two options:

### Option 1: Download via module settings

Go to **Modules > Configure > AlpineJS** and click the download button. This fetches the latest Alpine.js core and plugins from unpkg.com and stores them locally in the module's `js/` directory.

### Option 2: Custom file path

If you prefer to manage the Alpine.js file yourself (e.g. to version-control it), set the **Custom Alpine.js file path** in the module settings. This should be a path relative to the site root, such as `site/templates/scripts/alpine.js`. When set, this file is used instead of the downloaded version.

You can also override the core script URL programmatically via hook:

```php
$wire->addHookAfter('AlpineJS::getCoreScriptUrl', function($event) {
    $event->return = '/site/templates/scripts/alpine.js';
});
```

## Usage

### Admin Backend

Alpine.js is automatically loaded in the ProcessWire admin. You can use it in your custom admin pages, hooks, or Inputfields.

### Frontend

To use Alpine.js in your frontend templates, output the scripts manually:

```php
// Load only Alpine Core
echo $modules->get('AlpineJS')->renderScripts();

// Load Alpine Core + Plugins
echo $modules->get('AlpineJS')->renderScripts(['intersect', 'persist']);
```
