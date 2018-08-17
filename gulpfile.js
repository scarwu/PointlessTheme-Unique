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
gulp.task('copy:static', function () {
    return gulp.src('src/static/**/*')
        .pipe(gulp.dest('src/boot'));
});

gulp.task('copy:assets:fonts', function () {
    return gulp.src('src/assets/fonts/*')
        .pipe(gulp.dest('src/boot/assets/fonts'));
});

gulp.task('copy:assets:images', function () {
    return gulp.src('src/assets/images/**/*')
        .pipe(gulp.dest('src/boot/assets/images'));
});

gulp.task('copy:vendor:fonts', function () {
    return gulp.src([
            'node_modules/font-awesome/fonts/*.{otf,eot,svg,ttf,woff,woff2}'
        ])
        .pipe(gulp.dest('src/boot/assets/fonts/vendor'));
});

gulp.task('copy:vendor:scripts', function () {
    return gulp.src([
            'node_modules/modernizr/modernizr.js'
        ])
        .pipe($.rename(function (path) {
            path.basename = path.basename.split('.')[0];
            path.extname = '.min.js';
        }))
        .pipe(gulp.dest('src/boot/assets/scripts/vendor'));
});

/**
 * Styles
 */
gulp.task('style:sass', function() {
    return compileTask.sass([
        'src/assets/styles/theme.{sass,scss}'
    ], 'src/boot/assets/styles');
});

/**
 * Complex
 */
gulp.task('complex:webpack', function () {
    var result = compileTask.webpack(
        'src/assets/scripts/theme.jsx',
        'src/boot/assets/scripts'
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
        'src/application/**/*',
        'src/boot/**/*',
        '!src/boot/uploads/**/*'
    ]).on('change', $.livereload.changed);

    // Static Files
    gulp.watch('src/assets/fonts/*', [
        'copy:assets:fonts'
    ]);

    gulp.watch('src/assets/images/**/*', [
        'copy:assets:images'
    ]);

    gulp.watch([
        'src/static/**/*',
        'src/static/.htaccess'
    ], [
        'copy:static'
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
gulp.task('release:copy:assets', function () {
    return gulp.src('src/boot/assets/**/*')
        .pipe(gulp.dest('theme/assets'));
});

gulp.task('release:copy:extensions', function () {
    return gulp.src('src/application/extensions/**/*')
        .pipe(gulp.dest('theme/extensions'));
});

gulp.task('release:copy:handlers', function () {
    return gulp.src('src/application/handlers/**/*')
        .pipe(gulp.dest('theme/handlers'));
});

gulp.task('release:copy:views', function () {
    return gulp.src('src/application/views/**/*')
        .pipe(gulp.dest('theme/views'));
});

gulp.task('release:copy:config', function () {
    return gulp.src('src/application/config.php')
        .pipe(gulp.dest('theme'));
});

// Optimize
gulp.task('release:optimize:scripts', function () {
    return gulp.src('theme/assets/scripts/**/*')
        .pipe($.uglify())
        .pipe(gulp.dest('theme/assets/scripts'));
});

gulp.task('release:optimize:styles', function () {
    return gulp.src('theme/assets/styles/**/*')
        .pipe($.cssnano())
        .pipe(gulp.dest('theme/assets/styles'));
});

gulp.task('release:optimize:images', function () {
    return gulp.src('theme/assets/images/**/*')
        .pipe($.imagemin())
        .pipe(gulp.dest('theme/assets/images'));
});

/**
 * Clean Temp Folders
 */
gulp.task('clean:prepare', function (callback) {
    return del([
        'src/boot'
    ], callback);
});

gulp.task('clean:release', function (callback) {
    return del([
        'theme'
    ], callback);
});

gulp.task('clean:all', function (callback) {
    return del([
        'release',
        'src/boot',
        'src/application/vendor',
        'node_modules',
        'package.lock',
        'yarn.lock',
        'composer.lock'
    ], callback);
});

/**
 * Bundled Tasks
 */
gulp.task('prepare', function (callback) {
    run('clean:prepare', [
        'copy:static'
    ], [
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
        'release:copy:assets',
        'release:copy:extensions',
        'release:copy:handlers',
        'release:copy:views',
        'release:copy:config'
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
