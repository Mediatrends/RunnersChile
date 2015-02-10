module.exports = function(grunt){
	require('jit-grunt')(grunt);
	require('time-grunt')(grunt);
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		watch:{
			configFiles:{
				files:['prod/sass/**/*.scss','prod/js/**/*.js','app/wp-content/themes/runnerschile/**/*.php'],
				options:{
					livereload: true,
					spawn: false,
				},
			},

			sass:{
				files:['prod/sass/**/*.scss'],
				tasks: ['sass:deve'],
				options:{
					livereload:true,
					spawn: false,
				},
			},

			javascript:{
				files:['prod/js/**/*.js','Gruntfile.js'],
				tasks:['jshint','uglify:beauty'],
				options:{
					livereload:true,
					spawn: false,
				},
			},
		},

		sass: {
			deve: {
				options: {
					style: 'nested',
					sourcemap:'none'
				},
				files: {
					'app/wp-content/themes/runnerschile/css/main.min.css': 'prod/sass/main.scss'
				},
			},
			dist: {
				options: {
					style: 'compressed',
					sourcemap:'none'
				},
				files: {
					'app/wp-content/themes/runnerschile/css/main.min.css': 'prod/sass/main.scss'
				},
			},
		},

		jshint:{
			all:[
				'Gruntfile.js','prod/js/**/*.js'
			]
		},

		uglify:{
			beauty:{
				options:{
					beautify:true
				},
				files:{
			        'app/wp-content/themes/runnerschile/js/output.min.js': ['prod/js/script.js']
			    }
			},
			all:{
				files:{
			        'app/wp-content/themes/runnerschile/js/output.min.js': ['prod/js/script.js']
			    }
			}
		},

		imagemin:{
			options: {
				cache: false
			},
			dynamic: {                       // Another target
		      files: [{
		        expand: true,                  // Enable dynamic expansion
		        cwd: 'prod/img/',                   // Src matches are relative to this path
		        src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
		        dest: 'app/wp-content/themes/runnerschile/images/'                  // Destination path prefix
		      }]
		    },
		},

	    concurrent: {
	        target: {
	        	tasks:['sass','jshint','uglify'],
		    	options: {
	                logConcurrentOutput: true
	            },
		    }
	    },

	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-concurrent');

	grunt.registerTask('dev', ['concurrent','watch']);
	grunt.registerTask('default', ['uglify:all','imagemin','sass:dist']);

};