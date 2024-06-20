## Installation

> Note: This package only supports PHP 8.2 or higher, and Laravel 10.x/11.x.

You can install the package using Composer:

```bash
composer require foxws/wireuse
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="wireuse-config"
```

Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag="wireuse-views"
```

> NOTE: It is recommended to build or extend views instead.

### Tailwind

In order to render and build Tailwind CSS classes, you also need to include the vendor paths in your `tailwind.config.js`:

```js
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import preset from "./vendor/foxws/wireuse/resources/css/presets/tailwind.config.preset";
import theme from "./resources/support/tailwind.config.preset";

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset, theme],
  content: [
    "./resources/**/*.blade.php",
    "./src/**/*.php",
    "./vendor/foxws/wireuse/**/*.php",
    "./vendor/foxws/wireuse/**/*.blade.php",
  ],
  plugins: [forms, typography],
};
```
