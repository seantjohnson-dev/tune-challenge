/**
 * Compiles SCSS files into CSS.
 *
 * ---------------------------------------------------------------
 *
**/
module.exports = function(grunt) {

	var loadPath = [
    "bower_components/bourbon/app/assets/stylesheets",
    "bower_components/neat/app/assets/stylesheets",
    "bower_components/bourbon-tonic/stylesheets",
    "bower_components/meyer-reset/stylesheets"
  ],
  sassIn = "assets/styles/main.scss",
  cssOutDev = ".tmp/public/styles/main.css",
  cssOutBuild = ".tmp/public/styles/main.min.css",
  sassDevFiles = {},
  sassBuildFiles = {};

  sassDevFiles[cssOutDev] = [sassIn];
  sassBuildFiles[cssOutBuild] = [sassIn];

	grunt.config.set('sass', {
		dev: {
			options: {
        style: "expanded",
        loadPath: loadPath
      },
      files: sassDevFiles
		},
    build: {
      options: {
        style: "compact",
        loadPath: loadPath
      },
      files: sassBuildFiles
    }
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
};
