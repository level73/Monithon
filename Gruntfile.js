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
						src: 'public/src/components/popper.js/dist/popper.min.js',
						dest: 'public/js/vendor/popper.min.js'
					}
          /*,
					{
						src: 'public/src/components/jquery.bootgrid/dist/jquery.bootgrid.min.js',
						dest: 'public/js/vendor/jquery.bootgrid.min.js'
					},
					{
						src: 'public/src/components/jquery.bootgrid/dist/jquery.bootgrid.far.min.js',
						dest: 'public/js/vendor/jquery.bootgrid.fa.min.js'
					},
					{
						src: 'public/src/components/jquery.bootgrid/dist/jquery.bootgrid.min.css',
						dest: 'public/css/vendor/jquery.bootgrid.min.css'
					},
					{
						src: 'public/src/components/bootstrap-select/dist/js/bootstrap-select.min.js',
						dest: 'public/js/vendor/bootstrap-select.min.js'
					},
					{
						src: 'public/src/components/bootstrap-select/dist/css/bootstrap-select.min.css',
						dest: 'public/css/vendor/bootstrap-select.min.css'
					},
					{
						src: 'public/src/components/jasny/dist/js/jasny-bootstrap.min.js',
						dest: 'public/js/vendor/jasny-bootstrap.min.js'
					},
          {
						src: 'public/src/components/d3/d3.min.js',
						dest: 'public/js/vendor/d3.min.js'
					},
          {
						src: 'public/src/components/moment/min/moment-with-locales.min.js',
						dest: 'public/js/vendor/moment-with-locales.min.js'
					},
          {
						src: 'public/src/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
						dest: 'public/js/vendor/bootstrap-datetimepicker.min.js'
					},
          {
						src: 'public/src/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
						dest: 'public/css/vendor/bootstrap-datetimepicker.min.css'
					},
					{
						src: 'public/src/components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
						dest: 'public/css/vendor/jasny-bootstrap.min.css'
					},
          {
						src: 'public/src/components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
						dest: 'public/js/vendor/jasny-bootstrap.min.js'
					},
          {
						src: 'public/src/components/css-toggle-switch/dist/toggle-switch.css',
						dest: 'public/css/vendor/toggle-switch.css'
					},
          {
						src: 'public/src/components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
						dest: 'public/css/vendor/awesome-bootstrap-checkbox.css'
					},
          {
						src: 'public/src/components/bootstrap-validator/dist/validator.min.js',
						dest: 'public/js/vendor/validator.min.js'
					},

          {
						src: 'public/src/components/summernote/dist/summernote.css',
						dest: 'public/css/vendor/summernote.css'
					},
          {
						src: 'public/src/components/summernote/dist/summernote.min.js',
						dest: 'public/js/vendor/summernote.min.js'
					},
          {
						src: 'public/src/components/jquery.serializeJSON/jquery.serializeJSON.min.js',
						dest: 'public/js/vendor/jquery.serializeJSON.min.js'
					},

          {
            src: 'public/src/components/jvectormap/jquery-jvectormap.js',
            dest: 'public/js/vendor/jquery-jvectormap.js'
          },

          {
            src: 'public/src/components/jvectormap/jquery-jvectormap.css',
            dest: 'public/css/vendor/jquery-jvectormap.css'
          },

          {
            src: 'public/src/components/chart.js/dist/Chart.min.js',
            dest: 'public/js/vendor/Chart.min.js'
          },
          */
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
							]);
};
