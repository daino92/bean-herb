const { src, dest, watch, series, parallel } = require('gulp'),
    sourcemaps = require('gulp-sourcemaps'),
    sass = require('gulp-sass'),
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
    responsive = require("gulp-responsive"),
    replace = require('gulp-replace'),
    copy = require('gulp-copy'),
    log = require('fancy-log');

const path = { 
    styles: {
        src: 'resources/scss/*.scss',
        dest: 'dist/styles',
    },
    scripts: {
        src: 'resources/js/**/*.js',
        dest: 'dist/scripts'
    },
    svg: {
        src: 'assets/svg/*.svg',
        dest: 'dist/svg'
    },
    fonts: {
        src: 'resources/fonts/**/*',
        dest: 'dist/fonts'
    },
    img: {
        //src: '../../uploads/**/**/*.{jpg,png}',
        src: 'resources/images/*.{jpg,png}',
        dest: 'dist/images'
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
        '!resources/js/**.min.js'
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

function responsiveImages() {
    return src(path.img.src)
    .pipe(
        responsive(
            {
                '*.jpg': [
                {
                    width: 300,
                    rename: {
                        suffix: '-300px',
                        extname: '.jpg'
                    }
                },
                {
                    width: 600,
                    rename: {
                        suffix: '-600px',
                        extname: '.jpg'
                    }
                },
                {
                    width: 1900,
                    rename: {
                        suffix: '-1900px',
                        extname: '.jpg'
                    },
                    // Do not enlarge the output image if the input image are already less than the required dimensions.
                    withoutEnlargement: true
                },
                {
                    // Convert images to the webp format
                    width: 630,
                    rename: {
                        suffix: '-630px',
                        extname: '.webp'
                    }
                }],
                '*.png': [
                {
                    width: "50%"
                },
                {
                    width: "75%",
                    rename: { suffix: '@2x' }
                }]
            },
            {
                // Global configuration for all images
                quality: 80,
                progressive: true,
                withMetadata: false,
                errorOnEnlargement: false
            }
        )
    )
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
        files.scssPath, 
        files.jsPath
    ],
    {
        interval: 1000, 
        usePolling: true
    },
    series(
        parallel(css, js),
        //uncache
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

exports.clean = clean;
exports.css = styles;
exports.js = scripts;
exports.img = responsiveImages;
exports.svg = svg;
exports.fonts = copyFonts;
exports.watcher = watcher;

exports.default = series(
    // clean,
    // parallel(styles, scripts), 
    // copyFonts,
    // responsiveImages,
    svg,
    //watcher
);