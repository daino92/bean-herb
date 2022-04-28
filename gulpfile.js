const { src, dest, watch, series, parallel } = require('gulp'),
    sourcemaps = require('gulp-sourcemaps'),
    sass = require('gulp-dart-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano'),
    concat = require('gulp-concat'),
    babel = require('gulp-babel'),
    uglify = require('gulp-uglify-es').default,
    rename = require('gulp-rename'),
    del = require('del'),
    svgSprite = require('gulp-svg-sprite'),
    svgmin = require("gulp-svgmin"),
    cheerio = require('gulp-cheerio'),
    replace = require('gulp-replace'),
    copy = require('gulp-copy'),
    log = require('fancy-log'),
    changed = require('gulp-changed'),
    sharpResponsive = require("gulp-sharp-responsive");

const path = { 
    styles: {
        src: 'resources/scss/*.scss',
        dest: 'dist/styles',
        watch: 'resources/scss/**/**/**'
    },
    scripts: {
        src: 'resources/js/*.js',
        dest: 'dist/scripts',
        watch: 'resources/js/*.js',
        srcLibs: 'resources/js/**.min.js'
    },
    svg: {
        src: 'resources/svg/*.svg',
        dest: 'dist/svg',
        watch: 'resources/svg/*.svg'
    },
    fonts: {
        src: 'resources/fonts/**/*',
        dest: 'dist/fonts'
    },
    img: {
        src: 'resources/images/**/*.+(png|jpg|jpeg)',
        dest: 'dist/images',
        excl: 'resources/images/**/*.gif'
    }
}

const uglifyOptions = {
    compress: {
        drop_console: true
    }
}

const sassOptions = {
    errLogToConsole: true,
    outputStyle: 'expanded'   
}

function styles(){    
    return src(path.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions).on('error', function(err){
            log.error(err.message);
        }))
        .pipe(dest(path.styles.dest))
        .pipe(postcss([ autoprefixer(), cssnano() ])) 
        .pipe(rename({ extname: '.min.css' }))
        .pipe(sourcemaps.write('.'))
        .pipe(dest(path.styles.dest));
}

function scripts(){
    return src([
        path.scripts.src,
        `!${path.scripts.srcLibs}`
        ])
        .pipe(dest(path.scripts.dest))
        .pipe(sourcemaps.init())
        //.pipe(concat('all.js'))
        .pipe(babel())
        .pipe(uglify(uglifyOptions).on('error', function(e){
            console.log(e);
        }))
        .pipe(rename({ extname: '.min.js' }))
        .pipe(sourcemaps.write('.'))
        .pipe(dest(path.scripts.dest));
}

function svg() {
    return src(path.svg.src)
		.pipe(svgmin({
			js2svg: {
				pretty: true
			}
		}))
		.pipe(cheerio({
			run: function($) {
				$('[fill]').removeAttr('fill');
				$('[stroke]').removeAttr('stroke');
				$('[style]').removeAttr('style');
			},
			parserOptions: {
                xmlMode: true
            }
		}))
        // cheerio plugin create unnecessary string '&gt;', so replace it.
		.pipe(replace('&gt;', '>'))
		.pipe(svgSprite({
			mode: {
				symbol: {
					sprite: "../sprite.svg",
                    example: true,
                    bust: false
				}
			}
		}))
		.pipe(dest(path.svg.dest));
}

function minifyImages() {
    return src([
        path.img.src,
        `!${path.img.excl}`
    ])
    .pipe(changed(path.img.dest))
    .pipe(
        sharpResponsive({
            formats: [
                {width: 768, format: "jpeg"},
                {width: 1920, format: "png"},
                {width: 768, format: "webp"},
            ]
        })
    )
    .pipe(dest(path.img.dest))
    .pipe(src(path.img.excl))
    .pipe(dest(path.img.dest))
}

function uncache(){
    var cbString = new Date().getTime();
    return src(['index.html'])
        .pipe(replace(/v=\d+/g, 'v=' + cbString))
        .pipe(dest('.'));
}

function watcher(){
    watch([
        path.styles.watch, 
        path.scripts.watch,
        path.svg.watch
    ],
    {
        interval: 1000, 
        usePolling: true,
        ignoreInitial: false
    },
    series(
        parallel(styles, scripts),
        svg
    ));
}

function clean() {
    return del('dist/**', {
        force: true
    });
}

function copyFonts() {
    return src(path.fonts.src)
        .pipe(dest(path.fonts.dest))
}

function jsLibs() {
    return src(path.scripts.srcLibs)
        .pipe(dest(path.scripts.dest))
}

exports.clean = clean;
exports.css = styles;
exports.js = scripts;
exports.img = minifyImages;
exports.svg = svg;
exports.jsLibs = jsLibs;
exports.watcher = watcher;

exports.default = series(
    clean,
    parallel(styles, scripts), 
    jsLibs,
    copyFonts,
    minifyImages,
    svg,
    watcher
);