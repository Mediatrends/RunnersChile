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

			javascript:{
				files:['prod/js/**/*.js','Gruntfile.js'],
				tasks:['jshint','uglify:beauty'],
				options:{
					livereload:true,
					spawn: false,
				},
			},
		},

		jshint:{
			all:[
				'Gruntfile.js','prod/js/**/*.js'
			]
		},

		uglify:{
			all:{
				files: [{
		            expand: true,
		            src: '**/*.js',
		            dest: 'prod/js01',
		            cwd: 'prod/js'
		        }]
			},
		},

		imagemin:{
			options: {
				cache: false
			},
			dynamic: {
		      files: [{
		        expand: true,
		        cwd: 'prod/img/',
		        src: ['**/*.{png,jpg,gif}'],
		        dest: 'app/wp-content/themes/runnerschile/images/'
		      }]
		    },
		    dynamic2: {
		      files: [{
		      	optimizationLevel: 5,
		        expand: true,
		        cwd: 'prod/upload/',
		        src: ['**/*.{png,jpg,gif}'],
		        dest: 'prod/upload2/'
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
	grunt.registerTask('default', [/*'uglify:all',*/'imagemin'/*,'sass:dist'*/	]);

};