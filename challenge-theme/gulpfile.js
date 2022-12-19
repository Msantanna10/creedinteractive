'use strict';

const gulp = require('gulp');
// const concat = require('gulp-concat');
// const cleanCSS = require('gulp-clean-css');
const combine = require('gulp-scss-combine');
const sass = require('gulp-sass')(require('sass'));
const del = require('del');
const sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', function(done) {
    return gulp.src('./src/scss/*.scss')
        .pipe(combine())                
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass({
          outputStyle: 'compressed'
        }).on('error', sass.logError))
        //.pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./dist/css'))
        .on('end', done);
});

gulp.task('watch', function() {
    gulp.watch(['./src/scss/**/*.scss'], gulp.series(['sass']));
});

gulp.task('clean', function() {
    return del([
        './dist/css/*',
    ]);
});

gulp.task('build', gulp.series(['clean', 'sass']));

gulp.task('default', gulp.series(['clean', 'sass', 'watch']));