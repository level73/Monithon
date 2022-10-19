module.exports = function(grunt) {

  "use strict";

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

      concat: {
          options: {
            // define a string to put between each file in the concatenated output
            separator: grunt.util.linefeed + '/* --- concatenate --- */' + grunt.util.linefeed,
            stripBanners: true,
            sourceMap: true
          },
          dist: {
            // the files to concatenate
            src: ['public/src/js/script.js', 'public/src/js/<%= pkg.name %>.js'],
            // the location of the resulting JS file
            dest: 'public/src/js/<%= pkg.name %>.concat.js'
          },
	  },

      sass: {
        always: {
          files: {
            'public/css/main.css': 'public/src/sass/main.scss'
          }
        }
      },

      copy: {
		build: {
    	  files: [
			{
			    src: 'public/src/components/jquery/dist/jquery.min.js',
				dest: 'public/js/vendor/jquery.min.js'
            },
            {
			    src: 'public/src/components/bootstrap/dist/js/bootstrap.min.js',
				dest: 'public/js/vendor/bootstrap.min.js'
			},
            {
				src: 'public/src/components/bootstrap/dist/css/bootstrap.min.css',
				dest: 'public/css/vendor/bootstrap.min.css'
			},
            {
				src: 'public/src/components/popper.js/dist/umd/popper.min.js',
				dest: 'public/js/vendor/popper.min.js'
			},
            {
				src: 'public/src/components/bootstrap-select/dist/js/bootstrap-select.min.js',
				dest: 'public/js/vendor/bootstrap-select.min.js'
			},
            {
				src: 'public/src/components/bootstrap-table/dist/bootstrap-table.min.js',
				dest: 'public/js/vendor/bootstrap-table.min.js'
			},
            {
                src: 'public/src/components/bootstrap-table/dist/bootstrap-table.min.css',
                dest: 'public/css/vendor/bootstrap-table.min.css'
            },
              {
                  src: 'public/src/components/animate-css/animate.min.css',
                  dest: 'public/css/vendor/animate.min.css'
              },
          ]
		}
	  },

      uglify: {
        js: {
          options: {
             preserveComments: false
          },
          files: {
            'public/js/script.min.js': ['public/src/js/<%= pkg.name %>.concat.js'],
			'public/js/main.min.js': ['public/src/js/main.js']
          }
        }
      },

	  watch: {
        concat: {
          files: ['public/src/js/vendor/*.js', 'public/src/js/<%= pkg.name %>.js', 'public/src/js/script.js'],
          tasks: 'concat'
        },
        sass: {
          files: 'public/src/sass/*',
          tasks: 'sass:always',
          options: {
            livereload: true
          }
        },
        uglify: {
          files: ['public/src/js/<%= pkg.name %>.concat.js', 'public/src/js/main.js'],
          tasks: 'uglify:js'
        }
      }

	});

	// Load plugins
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Register tasks
	grunt.registerTask('default', ['watch']);
	grunt.registerTask('build', [
							'copy:build',
							'sass:always',
							'concat:dist',
							'uglify:js'
							]
    );
};
