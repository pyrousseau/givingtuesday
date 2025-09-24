'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('autoprefixer'),
    spritesmith = require('gulp.spritesmith'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    cssmin = require('gulp-minify-css'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    rimraf = require('rimraf'),
    postcss = require('gulp-postcss'),
    rigger = require('gulp-rigger'),
    browserSync = require("browser-sync"),
    reload = browserSync.reload;

var project = 'Y:/givingtuesday/wwwroot/wp-content/themes/theme/',
    path = {
    build: { //Path for build file's
        html: project + 'app/',
        js: project + 'app/js/',
        css: project + 'css/',
        img: project + 'app/images/',
        fonts: project + 'app/fonts/'
    },
    src: { //Path for dev file's
        html: project + 'src/*.html',
        js: project + 'src/js/main.js',
        style: project + 'scss/*.scss',
        styleSprite: project + 'scss/partials/',
        img: project + 'src/images/img/**/*.*',
        imgSprite: project + 'src/images/sprite/*.*',
        fonts: project + 'src/fonts/**/*.*'
    },
    watch: { //Path for watcher's
        html: project + 'src/**/*.html',
        js: project + 'src/js/**/*.js',
        style: project + 'scss/**/*.scss',
        img: project + 'src/images/**/*.*',
        fonts: project + 'src/fonts/**/*.*'
    },
    clean: './build'
};

//Config for webserver
var config = {
    server: {
        baseDir: "./app"
    },
    tunnel: true,
    host: 'localhost',
    port: 9000,
    logPrefix: "Frontend_WolF"
};

//compile html
gulp.task('html:build', function () {
    gulp.src(path.src.html)
        .pipe(rigger())
        .pipe(gulp.dest(path.build.html))
        .pipe(reload({stream: true}));
});

//compile js
gulp.task('js:build', function () {
    gulp.src(path.src.js)
        .pipe(rigger())
        //.pipe(sourcemaps.init())
        //.pipe(uglify())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.build.js))
        .pipe(reload({stream: true}));
});

//custom post css
//error
var customPostCSS = function(css) {
    css.eachDecl(function(decl, i) {
        if (decl.prop === 'opacity') {
            decl.parent.insertAfter(i, {
                prop: '-ms-filter',
                value: '"progid:DXImageTransform.Microsoft.Alpha(Opacity=' + (parseFloat(decl.value) * 100) + ')"'
            });
        }
    });
};

//compile css
gulp.task('style:build', function () {
    gulp.src(path.src.style)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([
            autoprefixer({browsers: ['last 3 versions']})
            // customPostCSS
        ]))
       // .pipe(cssmin())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.build.css))
        .pipe(reload({stream: true}));
});

//compile img
gulp.task('image:build', function () {

    //sprite generation
    var spriteData =
        gulp.src(path.src.imgSprite)
            .pipe(spritesmith({
                imgName: 'sprite.png',
                imgPath: '../images/sprite.png',
                padding: 20,
                cssFormat: 'scss',
                cssName: 'sprite.scss',
                algorithm: 'binary-tree',
                cssVarMap: function(sprite) {
                    sprite.name = 'sprite-' + sprite.name
                }
            }));
    spriteData.img.pipe(gulp.dest(path.build.img));
    spriteData.css.pipe(gulp.dest(path.src.styleSprite));

    //image min
    gulp.src(path.src.img)
        /*.pipe(imagemin({
     exclude: path.src.imgSprite,
     progressive: true,
     svgoPlugins: [{removeViewBox: false}],
     use: [pngquant()],
     interlaced: true
     }))*/
        .pipe(gulp.dest(path.build.img))
        .pipe(reload({stream: true}));
});

//copy fonts
gulp.task('fonts:build', function() {
    gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.build.fonts))
});

gulp.task('build', [
    // 'html:build',
    //'js:build',
    //'image:build',
    'style:build',
    //'fonts:build'
]);

gulp.task('watch', function () {
    //gulp.watch(path.watch.html, ['html:build']);
    gulp.watch(path.watch.style, ['style:build']);
    //gulp.watch(path.watch.js, ['js:build']);
    //gulp.watch(path.watch.img, ['image:build']);
    //gulp.watch(path.watch.fonts, ['fonts:build']);
});

gulp.task('clean', function (cb) {
    rimraf(path.clean, cb);
    gulp.start('build');
});

gulp.task('webserver', function () {
    browserSync(config);
});