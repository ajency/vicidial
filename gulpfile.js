
var gulp = require('gulp'),
    cleanCSS = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    csso = require('gulp-csso'),
    prefix = require('gulp-autoprefixer'),
    sass = require('gulp-sass')
    // browserSync = require('browser-sync').create()

// Minifies JS
gulp.task('scripts', function(){
    return gulp.src(['public/js/bootstrap.min.js', 'public/js/jquery.fancybox.js', 'public/js/slick.min.js', 'public/js/jquery.mmenu.all.js', 'public/js/jquery.mousewheel.min.js', 'public/js/lightgallery-all.min.js', 'public/js/lazysizes.min.js','public/js/bootstrap-select.min.js', 'public/js/jquery.autocomplete.js'])
    .pipe(uglify())
    .pipe(concat('combine.js'))
    .pipe(gulp.dest('public/js'))
});

/*==========  Minify and concat different styles files  ==========*/

// SASS Version
gulp.task('sass', function() {
    return gulp.src('public/scss/custom.scss')
        .pipe(sass())
        // Minify the file
        .pipe(csso())
        .pipe(gulp.dest("public/css"))
        // .pipe(browserSync.stream());
});


// SCSS Version
//gulp.task('styles', function(){
    //return gulp.src('src/scss/**/*.scss')
    //.pipe(sass())
    //.pipe(prefix('last 2 versions'))
    //.pipe(concat('main.css'))
    //.pipe(minifyCSS())
    //.pipe(gulp.dest('public/css'))
//});


// CSS Version

gulp.task('css', function(){
    // return gulp.src('./themes/kss/static/css/*.css')
    return gulp.src(['public/css/hamburgers.css', 'public/css/jquery.fancybox.css', 'public/css/jquery.mmenu.all.css', 'public/css/lightgallery.css', 'public/css/xzoom.css','public/css/bootstrap-select.min.css', 'public/css/custom.css'])
     .pipe(csso())
     .pipe(concat('combine.css'))
   .pipe(gulp.dest('public/css'))
});

// gulp.task('default', function() {
//     gulp.run('scripts')
//     gulp.run('css')

// });

gulp.task('watch', function() {
    gulp.watch(['public/scss/*.scss'], ['sass']);
    gulp.watch(['public/css/hamburgers.css', 'public/css/jquery.fancybox.css', 'public/css/jquery.mmenu.all.css', 'public/css/lightgallery.css', 'public/css/xzoom.css','public/css/bootstrap-select.min', 'public/css/custom.css'], ['css']);
    gulp.watch(['public/js/bootstrap.min.js', 'public/js/jquery.fancybox.js', 'public/js/slick.min.js', 'public/js/jquery.mmenu.all.js', 'public/js/jquery.mousewheel.min.js', 'public/js/lightgallery-all.min.js', 'public/js/lazysizes.min.js', 'public/js/jquery.autocomplete.js'], ['scripts']);
});
