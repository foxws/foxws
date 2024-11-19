import { fontFamily } from "tailwindcss/defaultTheme";
import colors from "tailwindcss/colors";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
  theme: {
    extend: {
      fontFamily: {
        sans: ["Jost", fontFamily.sans],
        serif: ["Montserrat", fontFamily.serif],
        mono: ["IBM Plex Mono", fontFamily.mono],
      },
      colors: {
        primary: colors.slate,
        secondary: colors.zinc,
        info: colors.blue,
        success: colors.gray,
        error: colors.red,
        warning: colors.yellow,
      },
      container: {
        center: true,
        padding: "1.5rem",
      },
      brightness: {
        80: ".8",
        85: ".85",
      },
    },
  },
  plugins: [forms, typography],
};
