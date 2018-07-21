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

function createSrcAndDest(path) {
    var src = path.replace(process.env.PWD + '/', '');
    var dest = src.replace('src/assets', 'src/boot/assets').split('/');

    dest.pop();

    return {
        src: src,
        dest: dest.join('/')
    };
}

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
    return gulp.src([
            'src/static/**/*',
            'src/static/.htaccess'
        ])
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
        'src/assets/styles/main.{sass,scss}',
        'src/assets/styles/print.{sass,scss}'
    ], 'src/boot/assets/styles');
});

/**
 * Complex
 */
gulp.task('complex:webpack', function () {
    var result = compileTask.webpack(
        'src/assets/scripts/main.jsx',
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
gulp.task('release:copy:boot', function () {
    return gulp.src([
            'src/boot/**/*',
            'src/boot/.htaccess'
        ])
        .pipe(gulp.dest('release/boot'));
});

gulp.task('release:copy:application', function () {
    return gulp.src('src/application/**/*')
        .pipe(gulp.dest('release/application'));
});

// Replace
gulp.task('release:replace:index', function () {
    return gulp.src('release/boot/index.php')
        .pipe($.replace(
            'define(\'ENVIRONMENT\', \'development\');',
            'define(\'ENVIRONMENT\', \'production\');'
        ))
        .pipe(gulp.dest('release/boot'));
});

gulp.task('release:replace:config', function () {
    return gulp.src('release/application/config/config.php')
        .pipe($.replace(
            '(int) (array_sum(explode(\' \', microtime())) * 1000)',
            postfix
        ))
        .pipe(gulp.dest('release/application/config'));
});

// Optimize
gulp.task('release:optimize:scripts', function () {
    return gulp.src('release/assets/scripts/**/*')
        .pipe($.uglify())
        .pipe(gulp.dest('release/assets/scripts'));
});

gulp.task('release:optimize:styles', function () {
    return gulp.src('release/assets/styles/**/*')
        .pipe($.cssnano())
        .pipe(gulp.dest('release/assets/styles'));
});

gulp.task('release:optimize:images', function () {
    return gulp.src('release/assets/images/**/*')
        .pipe($.imagemin())
        .pipe(gulp.dest('release/assets/images'));
});

/**
 * Clean Temp Folders
 */
gulp.task('clean', function (callback) {
    return del([
        'release',
        'src/boot'
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
    run('clean', [
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

    run('prepare', [
        'release:copy:boot',
        'release:copy:application'
    ], [
        'release:replace:index',
        'release:replace:config'
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
