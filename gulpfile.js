
var gulp = require('gulp'),
    gzip = require('gulp-gzip');
    // browserSync = require('browser-sync').create()

/*==========  Minify and concat different scripts files  ==========*/

// Minifies JS
// gulp.task('scripts', function(){
//     return gulp.src(['public/js/bootstrap.min.js', 'public/js/jquery.fancybox.js', 'public/js/slick.min.js', 'public/js/bootstrap-better-nav.min.js', 'public/js/jquery.mousewheel.min.js', 'public/js/lightgallery-all.min.js', 'public/js/lazysizes.min.js','public/js/bootstrap-select.min.js', 'public/js/jquery.autocomplete.js'])
//     .pipe(uglify())
//     .pipe(concat('combine.js'))
//     .pipe(gulp.dest('public/js'))
// });

/*==========  Minify and concat different styles files  ==========*/

// SASS Version
// gulp.task('sass', function() {
//     return gulp.src('public/scss/custom.scss')
//         .pipe(sass())
//         // Minify the file
//         .pipe(csso())
//         .pipe(gulp.dest("public/css"))
//         .on('end', function(){ log('SASS compiled successfully'); });
//         // .pipe(browserSync.stream());
// });


// SCSS Version
//gulp.task('styles', function(){
    //return gulp.src('src/scss/**/*.scss')
    //.pipe(sass())
    //.pipe(prefix('last 2 versions'))
    //.pipe(concat('main.css'))
    //.pipe(minifyCSS())
    //.pipe(gulp.dest('public/css'))
//});


// CSS libraries/plugins combined
// gulp.task('css', function(){
//     // return gulp.src('./themes/kss/static/css/*.css')
//     return gulp.src(['public/css/jquery.fancybox.css', 'public/css/bootstrap-better-nav.min.css', 'public/css/lightgallery.css', 'public/css/xzoom.css','public/css/bootstrap-select.min.css', 'public/css/custom.css'])
//         .pipe(csso())
//         .pipe(concat('combine.css'))
//         .pipe(gulp.dest('public/css'))
//         .on('end', function(){ log('CSS updated successfully'); });
// });


// Compiling sass and css synchronously
// gulp.task('build-styles', function (done) {
//     sequence('sass', 'css', done);
// });


// Gulp watch
// gulp.task('watch', function() {
//     gulp.watch(['public/scss/*.scss'], ['sass']);
//     gulp.watch(['public/css/jquery.fancybox.css', 'public/css/bootstrap-better-nav.min.css', 'public/css/lightgallery.css', 'public/css/xzoom.css','public/css/bootstrap-select.min', 'public/css/custom.css'], ['css']);
//     gulp.watch(['public/js/bootstrap.min.js', 'public/js/jquery.fancybox.js', 'public/js/slick.min.js', 'public/js/bootstrap-better-nav.min.js', 'public/js/jquery.mousewheel.min.js', 'public/js/lightgallery-all.min.js', 'public/js/lazysizes.min.js', 'public/js/jquery.autocomplete.js'], ['scripts']);
// });

gulp.task('scripts', function() {
    gulp.src('./public/js/*.js')
    .pipe(gzip({ append: false }))
    .pipe(gulp.dest('./public/js'));
});
gulp.task('css', function() {
    gulp.src('./public/css/*.css')
    .pipe(gzip({ append: false }))
    .pipe(gulp.dest('./public/css'));
});
gulp.task('pwa-js', function() {
    gulp.src('./public/js/kss-pwa/*.js')
    .pipe(gzip({ append: false }))
    .pipe(gulp.dest('./public/js/kss-pwa'));
});
gulp.task('pwa-css', function() {
    gulp.src('./public/js/kss-pwa/*.css')
    .pipe(gzip({ append: false }))
    .pipe(gulp.dest('./public/js/kss-pwa'));
});

gulp.task('default', ['scripts', 'css', 'pwa-js', 'pwa-css']);
