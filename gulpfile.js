"use strict";

// Load plugins
const gulp          = require('gulp'),
    sass          = require('gulp-sass'),
    autoprefixer  = require('gulp-autoprefixer'),
    plumber       = require('gulp-plumber'),
    gutil         = require('gulp-util'),
    rename        = require('gulp-rename'),
    sourcemaps    = require('gulp-sourcemaps'),
    concat        = require('gulp-concat'),
    jshint        = require('gulp-jshint'),
    uglify        = require('gulp-uglify'),
    minifycss     = require('gulp-uglifycss' ),
    imagemin      = require('gulp-imagemin')

var onError = function( err ) {
  console.log('An error occurred:', gutil.colors.magenta(err.message));
  gutil.beep();
  this.emit('end');
};

// CSS task
function css() {
  return gulp
  .src('./sass/**/*.scss')
  .pipe( sourcemaps.init() )
  .pipe(plumber({ errorHandler: onError }))
  .pipe(sass())
  .pipe(autoprefixer())
  .pipe( minifycss({ "uglyComments": true }) )
  .pipe(sourcemaps.write('./sass/maps'))
  .pipe(gulp.dest('./'))
}

// JS task
function js() {
  return gulp
  .src(
    [
      './js/app.js'
    ]
  )
  .pipe(sourcemaps.init())
  .pipe(jshint())
  .pipe(jshint.reporter('default'))
  .pipe(concat('app.js'))
  .pipe(rename({suffix: '.min'}))
  .pipe(uglify())
  .pipe(sourcemaps.write('./maps'))
  .pipe(gulp.dest('./js'));
}

// Images task
function images() {
  return gulp
  .src('./images/src/*')
  .pipe(plumber({ errorHandler: onError }))
  .pipe(imagemin({ optimizationLevel: 7, progressive: true }))
  .pipe(gulp.dest('./images/dist'));
}

// Watch files
function watchFiles() {
  gulp.watch("./sass/**/*.scss", css);
  gulp.watch('images/src/*', images);
  gulp.watch(['./js/*.js', '!./js/app.min.js'], js);
}

exports.default = gulp.series(gulp.parallel(css, js, images, watchFiles));