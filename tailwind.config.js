import preset from "./vendor/foxws/wireuse/resources/css/presets/tailwind.config.preset";
import theme from "./resources/support/tailwind.config.preset";

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset, theme],
  relative: true,
  content: [
    "./resources/**/*.{blade.php,js}",
    "./src/**/*.{blade.php,js}",
    "./vendor/foxws/wireuse/src/**/*.{blade.php,php,js}",
  ],
};
