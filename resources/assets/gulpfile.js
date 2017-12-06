'use strict';
var gulp = require('gulp'),
	watch = require('gulp-watch'),
	preFixer = require('gulp-autoprefixer'),
	uglify = require('gulp-uglify'),
	concat = require('gulp-concat'),
	cssMin = require('gulp-minify-css'),
	imagemin = require('gulp-imagemin');

var path = {

	build: {
		css: '../../public/css/',
		js: '../../public/js/',
		img: '../../storage/app/public/upload/images/posts/'
	},

	src: {
		style: 'css/*.css',
		js: 'javaScript/jv-jquery-mobile-menu.js',
		img: '../../storage/app/public/upload/images/posts/**/*'
	},

	watch: {
		style: 'css/style.css'
	}
};

gulp.task('minify', function() {
	gulp.src(path.src.style)
	.pipe(preFixer({
          browsers: ['last 60 versions'],
          cascade: false
        }))
	.pipe(concat('main.css'))
	.pipe(cssMin())
	.pipe(gulp.dest(path.build.css));
});

gulp.task('minifyjs', function() {
	gulp.src(path.src.js)
	  .pipe(uglify())
	  .pipe(gulp.dest(path.build.js));
});

gulp.task('minifyimg', function() {
	gulp.src(path.src.img)
		.pipe(imagemin({
			optimizationLevel: 9
		}))
		.pipe(gulp.dest(path.build.img))
});