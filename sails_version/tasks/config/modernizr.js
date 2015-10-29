/**
 * Builds a custom modernizr based of what you reference from the library
 *
 * ---------------------------------------------------------------
 *
**/
module.exports = function(grunt) {

  var searchFiles = {
    src: [
      ".tmp/public/concat/production.js",
      "assets/styles/main.css"
    ]
  },
  devFile = "assets/js/vendor/modernizr-dev.js",
  destPath = ".tmp/public/";

	grunt.config.set('modernizr', {
    dev: {
      cache: true,
      devFile: devFile,
      dest: destPath + "modernizr.js",
      uglify: false,
      parseFiles: true,
      files : searchFiles
    },
    build: {
      cache: false,
      devFile: devFile,
      dest: destPath + "modernizr.min.js",
      uglify: true,
      parseFiles: true,
      files : searchFiles
    }
  });

	grunt.loadNpmTasks('grunt-modernizr');
};
