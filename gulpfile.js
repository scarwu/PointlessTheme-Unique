'use strict';

/**
 * @author      Scar Wu
 * @copyright   Copyright (c) Ovomedia Creative Inc.
 */
var ENVIRONMENT = 'development'; // production | development | testing

var gulp = require('gulp'),
    del = require('del'),
    run = require('run-sequence'),
    $ = require('gulp-load-plugins')(),
    process = require('process'),
    webpack = require('webpack'),
    webpackConfig = require('./webpack.config.js');

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
    less: function (src, dest) {
        return gulp.src(src)
            .pipe($.less({
                paths: dest
            }).on('error', handleCompileError))
            .pipe($.replace('../fonts/', '/assets/fonts/vendor/'))
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
                    NODE_ENV: JSON.stringify('production')
                }
            });

            webpackConfig.plugins = webpackConfig.plugins || [];
            webpackConfig.plugins.push(definePlugin);
        }

        return gulp.src(src)
            .pipe($.webpack(webpackConfig).on('error', handleCompileError))
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
gulp.task('style:less', function() {
    return compileTask.less([
        // 'src/assets/styles/**/*.less',
        'src/assets/styles/ovo.less'
    ], 'src/boot/assets/styles');
});

/**
 * Complex
 */
gulp.task('complex:webpack', function () {
    return compileTask.webpack(
        'src/assets/scripts/ovo.jsx',
        'src/boot/assets/scripts'
    );
});

/**
 * Shell Script
 */
gulp.task('shell:link', $.shell.task([
    'cd src/boot && ln -s ../uploads'
]));

gulp.task('shell:sourceguardian', $.shell.task([
    'sourceguardian --phpversion 5.5 -n -z9 -b- `find encrypt -name "*.php" -type f`'
]));

/**
 * Watching Files
 */
gulp.task('watch', function () {

    // Start LiveReload
    $.livereload.listen();

    gulp.watch([
        'src/application/**/*',
        'src/boot/**/*'
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
    gulp.watch('src/assets/styles/**/*.less', [
        'style:less'
    ]);

    gulp.watch([
        'src/assets/scripts/**/*.jsx'
    ], [
        'complex:webpack'
    ]);
});

/**
 * Encrypt
 */
gulp.task('encrypt:copy', function () {
    return gulp.src([
            'release/**/*',
            'release/**/*/.htaccess'
        ])
        .pipe(gulp.dest('encrypt'));
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
    return gulp.src('release/boot/assets/scripts/**/*')
        .pipe($.uglify({
            mangle: {
                except: ['require']
            }
        }))
        .pipe(gulp.dest('release/boot/assets/scripts'));
});

gulp.task('release:optimize:styles', function () {
    return gulp.src('release/boot/assets/styles/**/*')
        .pipe($.cssnano())
        .pipe(gulp.dest('release/boot/assets/styles'));
});

// gulp.task('release:optimize:images', function () {
//     return gulp.src('release/boot/assets/images/**/*')
//         .pipe($.imagemin())
//         .pipe(gulp.dest('release/boot/assets/images'));
// });

/**
 * Clean Temp Folders
 */
gulp.task('clean', function (callback) {
    return del([
        'encrypt',
        'release',
        'src/boot'
    ], callback);
});

gulp.task('clean:all', function (callback) {
    return del([
        'encrypt',
        'release',
        'src/boot',
        'src/application/vendor',
        'node_modules',
        'composer.lock'
    ], callback);
});

gulp.task('clean:link', function (callback) {
    return del([
        'src/boot/uploads'
    ], callback);
});

/**
 * Bundled Tasks
 */
gulp.task('prepare', function (callback) {
    run('clean', 'copy:static', [
        'copy:assets:fonts',
        'copy:assets:images',
        'copy:vendor:fonts',
        'copy:vendor:scripts'
    ], [
        'style:less',
        'complex:webpack'
    ], [
        'shell:link'
    ], callback);
});

gulp.task('release', function (callback) {

    // Warrning: Change ENVIRONMENT to Prodctuion
    ENVIRONMENT = 'production';

    run('prepare', [
        'clean:link'
    ], [
        'release:copy:boot',
        'release:copy:application'
    ], [
        'release:replace:index',
        'release:replace:config'
    ], [
        // 'release:optimize:images',
        'release:optimize:scripts',
        'release:optimize:styles'
    ], callback);
});

gulp.task('encrypt', function (callback) {
    run('release', [
        'encrypt:copy'
    ], [
        'shell:sourceguardian'
    ], callback);
});

gulp.task('default', function (callback) {
    run('prepare', 'watch', callback);
});
