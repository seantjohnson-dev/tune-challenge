/**
 * Checks JS files for errors and warnings.
 *
 * ---------------------------------------------------------------
 *
**/

module.exports = function(grunt) {

	grunt.config.set('jshint', {
    options: {
      jshintrc: '.jshintrc'
    },
    all: [
      'Gruntfile.js',
      'assets/js/*.js',
      '!assets/js/main.js',
      '!assets/**/*.min.*'
    ]
  });

	grunt.loadNpmTasks('grunt-contrib-jshint');
};
