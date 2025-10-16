// tailwind.config.js
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './node_modules/daisyui/**/*.js',
    // maybe include vendor blade paths
  ],
  theme: {
    extend: {
      // your extensions
    },
  },
  plugins: [
    require('daisyui'),
  ],
  daisyui: {
    // optional: themes, defaults, etc.
    themes: ['light', 'dark'],  
  },
};
