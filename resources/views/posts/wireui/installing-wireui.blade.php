## Installation

> Note: This package only supports PHP 8.2 or higher, and Laravel 10.x/11.x.

You can install the package using Composer:

```bash
composer require foxws/wireui
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="wireui-config"
```

Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag="wireui-views"
```

### Tailwind

When using [Tailwind CSS](https://tailwindcss.com/), make sure to register the templates in `tailwind.config.js`:

```js
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import preset from './vendor/foxws/wireui/resources/css/presets/tailwind.config.preset';
import theme from './resources/support/tailwind.config.preset';

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset, theme],
  content: [
    './resources/views/**/*.blade.php',
    './src/App/**/*.blade.php',
    './vendor/foxws/wireui/**/*.blade.php',
  ],
  plugins: [forms, typography],
};
```

