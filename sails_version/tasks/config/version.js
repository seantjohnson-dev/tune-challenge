/**
 * Compiles SCSS files into CSS.
 *
 * ---------------------------------------------------------------
 *
**/
module.exports = function(grunt) {

	grunt.config.set('version', {
    default: {
      options: {
        format: true,
        length: 32,
        manifest: manifestPath,
        querystring: {
          style: 'tune_css',
          script: 'tune_js'
        }
      },
      files: {
        'assets/{styles,js}/{main}.min.{css,js}'
      }
    }
  });

	grunt.loadNpmTasks('grunt-version');
};
