'use strict';
/**
 * Gulp Tasks
 *
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 */

var ENVIRONMENT = 'development'; // production | development | testing
var WEBPACK_NEED_WATCH = false;

var gulp = require('gulp');
var del = require('del');
var run = require('run-sequence');
var $ = require('gulp-load-plugins')();
var process = require('process');
var webpackStream = require('webpack-stream');
var webpack = require('webpack');
var webpackConfig = require('./webpack.config.js');

var postfix = (new Date()).getTime().toString();

function handleCompileError(event) {
    $.util.log($.util.colors.red(event.message), 'error.');
}

// Assets Compile Task
var compileTask = {
    sass: function (src, dest) {
        return gulp.src(src)
            .pipe($.sass().on('error', handleCompileError))
            .pipe($.replace('../fonts/', '../../assets/fonts/vendor/'))
            .pipe($.autoprefixer())
            .pipe($.rename(function (path) {
                path.basename = path.basename.split('.')[0];
                path.extname = '.min.css';
            }))
            .pipe(gulp.dest(dest));
    },
    webpack: function (src, dest) {
        if ('production' === ENVIRONMENT) {
            var definePlugin = new webpack.DefinePlugin({
                'process.env': {
                    'ENV': "'production'",
                    'BUILD_TIME': postfix,
                    'NODE_ENV': "'production'"
                }
            });

            webpackConfig.mode = ENVIRONMENT;
            webpackConfig.plugins = webpackConfig.plugins || [];
            webpackConfig.plugins.push(definePlugin);
        }

        if (WEBPACK_NEED_WATCH) {
            webpackConfig.watch = true;
        }

        return gulp.src(src)
            .pipe(webpackStream(webpackConfig, webpack).on('error', handleCompileError))
            .pipe(gulp.dest(dest));
    }
};

/**
 * Copy Files & Folders
 */
gulp.task('copy:meta', function () {
    return gulp.src([
            'src/constant.php',
            'src/config.php'
        ])
        .pipe(gulp.dest('temp'));
});

gulp.task('copy:extensions', function () {
    return gulp.src('src/extensions/**/*')
        .pipe(gulp.dest('temp/extensions'));
});

gulp.task('copy:handlers', function () {
    return gulp.src('src/handlers/**/*')
        .pipe(gulp.dest('temp/handlers'));
});

gulp.task('copy:views', function () {
    return gulp.src('src/views/**/*')
        .pipe(gulp.dest('temp/views'));
});

gulp.task('copy:assets:fonts', function () {
    return gulp.src('src/assets/fonts/*')
        .pipe(gulp.dest('temp/assets/fonts'));
});

gulp.task('copy:assets:images', function () {
    return gulp.src('src/assets/images/**/*')
        .pipe(gulp.dest('temp/assets/images'));
});

gulp.task('copy:vendor:fonts', function () {
    return gulp.src([
            'node_modules/font-awesome/fonts/*.{otf,eot,svg,ttf,woff,woff2}'
        ])
        .pipe(gulp.dest('temp/assets/fonts/vendor'));
});

gulp.task('copy:vendor:scripts', function () {
    return gulp.src([
            'node_modules/modernizr/modernizr.js'
        ])
        .pipe($.rename(function (path) {
            path.basename = path.basename.split('.')[0];
            path.extname = '.min.js';
        }))
        .pipe(gulp.dest('temp/assets/scripts/vendor'));
});

/**
 * Styles
 */
gulp.task('style:sass', function() {
    return compileTask.sass([
        'src/assets/styles/theme.{sass,scss}'
    ], 'temp/assets/styles');
});

/**
 * Complex
 */
gulp.task('complex:webpack', function () {
    var result = compileTask.webpack(
        'src/assets/scripts/theme.jsx',
        'temp/assets/scripts'
    );

    return WEBPACK_NEED_WATCH ? true : result;
});

/**
 * Watching Files
 */
gulp.task('watch', function () {

    // Start LiveReload
    $.livereload.listen();

    gulp.watch([
        'temp/**/*'
    ]).on('change', $.livereload.changed);

    gulp.watch('src/config.php', [
        'copy:meta'
    ]);

    gulp.watch('src/extensions/**/*', [
        'copy:extensions'
    ]);

    gulp.watch('src/handlers/**/*', [
        'copy:handlers'
    ]);

    gulp.watch('src/views/**/*', [
        'copy:views'
    ]);

    gulp.watch('src/assets/fonts/*', [
        'copy:assets:fonts'
    ]);

    gulp.watch('src/assets/images/**/*', [
        'copy:assets:images'
    ]);

    // Pre Compile Files
    gulp.watch('src/assets/styles/**/*.{sass,scss}', [
        'style:sass'
    ]);
});

/**
 * Release
 */
// Copy
gulp.task('release:copy:all', function () {
    return gulp.src('temp/**/*')
        .pipe(gulp.dest('dist'));
});

// Optimize
gulp.task('release:optimize:scripts', function () {
    return gulp.src('dist/assets/scripts/**/*')
        .pipe($.uglify())
        .pipe(gulp.dest('dist/assets/scripts'));
});

gulp.task('release:optimize:styles', function () {
    return gulp.src('dist/assets/styles/**/*')
        .pipe($.cssnano())
        .pipe(gulp.dest('dist/assets/styles'));
});

gulp.task('release:optimize:images', function () {
    return gulp.src('dist/assets/images/**/*')
        .pipe($.imagemin())
        .pipe(gulp.dest('dist/assets/images'));
});

/**
 * Clean Temp Folders
 */
gulp.task('clean:prepare', function (callback) {
    return del([
        'temp'
    ], callback);
});

gulp.task('clean:release', function (callback) {
    return del([
        'dist'
    ], callback);
});

gulp.task('clean:all', function (callback) {
    return del([
        'dist',
        'temp',
        'node_modules',
        'package.lock',
        'yarn.lock'
    ], callback);
});

/**
 * Bundled Tasks
 */
gulp.task('prepare', function (callback) {
    run('clean:prepare', [
        'copy:meta',
        'copy:extensions',
        'copy:handlers',
        'copy:views',
        'copy:assets:fonts',
        'copy:assets:images',
        'copy:vendor:fonts',
        'copy:vendor:scripts'
    ], [
        'style:sass',
        'complex:webpack'
    ], callback);
});

gulp.task('release', function (callback) {

    // Warrning: Change ENVIRONMENT to Prodctuion
    ENVIRONMENT = 'production';

    run('prepare', 'clean:release', [
        'release:copy:all'
    ], [
        'release:optimize:images',
        'release:optimize:scripts',
        'release:optimize:styles'
    ], callback);
});

gulp.task('default', function (callback) {

    // Webpack need watch
    WEBPACK_NEED_WATCH = true;

    run('prepare', 'watch', callback);
});
