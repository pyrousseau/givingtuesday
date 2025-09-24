// include plug-ins
var gulp = require('gulp'); 
var concat = require('gulp-concat');
var stripDebug = require('gulp-strip-debug');
var uglify = require('gulp-uglify');
var ngAnnotate = require('gulp-ng-annotate');

// JS concat, strip debugging and minify
gulp.task('grsFrontend', function() {
    // gulp.src('grsAdmin.js')
    // gulp.src(['./src/scripts/lib.js','./src/scripts/*.js'])
    return gulp.src('grsFrontend.js')
      .pipe(concat('grsFrontend.min.js'))
      .pipe(stripDebug())
      .pipe(ngAnnotate())
      .pipe(uglify())
      .pipe(gulp.dest('./'));
});

gulp.task('grsAdmin', function() {
    // gulp.src('grsFrontend.js')
    // gulp.src(['./src/scripts/lib.js','./src/scripts/*.js'])
    return gulp.src('grsAdmin.js')
        .pipe(concat('grsAdmin.min.js'))
        .pipe(stripDebug())
        .pipe(ngAnnotate())
        .pipe(uglify())
        .pipe(gulp.dest('./'));
});