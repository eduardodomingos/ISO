require('es6-promise').polyfill();

var gulp          = require('gulp'),
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
    imagemin      = require('gulp-imagemin'),
    browserSync   = require('browser-sync').create(),
    reload        = browserSync.reload;

var onError = function( err ) {
  console.log('An error occurred:', gutil.colors.magenta(err.message));
  gutil.beep();
  this.emit('end');
};

// Sass
gulp.task('sass', function() {
  return gulp.src('./sass/**/*.scss')
  .pipe( sourcemaps.init() )
  .pipe(plumber({ errorHandler: onError }))
  .pipe(sass())
  .pipe(autoprefixer())
  .pipe( minifycss({ "uglyComments": true }) )
  .pipe(sourcemaps.write('./sass/maps'))
  .pipe(gulp.dest('./'))
});

// JavaScript
gulp.task('js', function() {
  return gulp.src([
    './js/app.js'
  ])
  .pipe(sourcemaps.init())
  .pipe(jshint())
  .pipe(jshint.reporter('default'))
  .pipe(concat('app.js'))
  .pipe(rename({suffix: '.min'}))
  .pipe(uglify())
  .pipe(sourcemaps.write('./maps'))
  .pipe(gulp.dest('./js'));
});

// Images
gulp.task('images', function() {
  return gulp.src('./images/src/*')
  .pipe(plumber({ errorHandler: onError }))
  .pipe(imagemin({ optimizationLevel: 7, progressive: true }))
  .pipe(gulp.dest('./images/dist'));
});

// Watch
gulp.task('watch', function() {
  browserSync.init({
    files: ['./**/*.php'],
    open: 'external',
    proxy: 'eduardodomingoscom.local',
    port: 8080
  });
  gulp.watch('./sass/**/*.scss', ['sass', reload]);
  gulp.watch(['./js/*.js', '!./js/app.min.js'], ['js', reload]);
  gulp.watch('images/src/*', ['images', reload]);
});

gulp.task('default', ['sass', 'js', 'images', 'watch']);