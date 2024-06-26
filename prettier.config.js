export default {
  trailingComma: "es5",
  semi: true,
  singleQuote: false,
  printWidth: 100,
  plugins: ["prettier-plugin-tailwindcss"],
  overrides: [
    {
      files: ["*.blade.php"],
      options: {
        parser: "html",
        tailwindAttributes: ["class:"],
      },
    },
  ],
};
