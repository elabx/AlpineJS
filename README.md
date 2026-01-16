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
