var path = require('path');
var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minifyJs = require('gulp-minify');
var minifyCss = require('gulp-clean-css');
var merge = require('merge-stream');
var bs = require('browser-sync').create();

gulp.task('sass', function() {
  var options = {
    outputStyle: 'compressed'
  };

  return gulp
    .src('app/style/*.scss')
    .pipe(sass(options).on('error', sass.logError))
    .pipe(gulp.dest('public/assets/css'))
    .pipe(bs.stream())
  ;
});

gulp.task('script', function() {
  var options = {
      ext:{
        src:'-debug.js',
        min:'.js'
      },
      noSource: true,
  };
  var dashboardJs = gulp
    .src('app/script/*.js')
    .pipe(minifyJs(options))
    .pipe(gulp.dest('public/assets/js'))
    .pipe(bs.stream())
  ;

  return merge(dashboardJs);
});

gulp.task('vendor', function() {
  var options = {
      ext:{
        src:'-debug.js',
        min:'.js'
      },
      noSource: true,
  };
  var vendor1Js = gulp
    .src([
      'app/lib/fontawesome-5.0.8/js/fa-solid.js',
      'app/lib/fontawesome-5.0.8/js/fontawesome.js',
    ])
    .pipe(concat('vendor-1.bundle.js'))
    .pipe(minifyJs(options))
    .pipe(gulp.dest('public/assets/js'))
    .pipe(bs.stream())
  ;
  var vendor2Js = gulp
    .src([
      'node_modules/jquery/dist/jquery.js',
      'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
    ])
    .pipe(concat('vendor-2.bundle.js'))
    .pipe(minifyJs(options))
    .pipe(gulp.dest('public/assets/js'))
    .pipe(bs.stream())
  ;

  var vendor1Css = gulp
    .src([
      'node_modules/bootstrap/dist/css/bootstrap.css',
    ])
    .pipe(concat('vendor-1.bundle.css'))
    .pipe(minifyCss())
    .pipe(gulp.dest('public/assets/css'))
    .pipe(bs.stream())
  ;

  return merge(vendor1Js, vendor2Js, vendor1Css);
});

gulp.task('watch', ['sass', 'script', 'vendor'], function() {
  bs.init({
    proxy: 'http://localhost/~fal/me/' + path.basename(__dirname) + '/public',
    open: false,
    online: false,
    ghostMode: false,
    notify: false
  });

  gulp.watch('app/style/**/*.scss', ['sass']);
  gulp.watch('app/script/**/*.js', ['script']);
  gulp.watch('app/lib/**/*', ['vendor']);
  gulp.watch(['app/{config,template}/**/*','src/**/*'], bs.reload);
});

gulp.task('default', ['watch']);