import colors from 'tailwindcss/colors';

export default {
  darkMode: 'selector',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Jost, ui-sans-serif, system-ui, sans-serif'],
        serif: ['Montserrat', 'ui-serif', 'serif'],
        mono: ['IBM Plex Mono', 'ui-monospace', 'monospace'],
      },
      colors: {
        primary: colors.slate,
      },
    },
  },
};
