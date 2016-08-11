// 项目路径
var dir_src = 'F:/svn_php/online/api.jjys168.com/public/pc/static';
var gulp = require('gulp')
var gutil = require('gulp-util')
var uglify = require('gulp-uglify')
var watchPath = require('gulp-watch-path')
var combiner = require('stream-combiner2')
var sourcemaps = require('gulp-sourcemaps')
var minifycss = require('gulp-minify-css')
var autoprefixer = require('gulp-autoprefixer')
var less = require('gulp-less')
var sass = require('gulp-ruby-sass')
var imagemin = require('gulp-imagemin')
var handlebars = require('gulp-handlebars');
var wrap = require('gulp-wrap');
var declare = require('gulp-declare');
var rev = require('gulp-rev'); //- 对文件名加MD5后缀
var revCollector = require('gulp-rev-collector'); //- 路径替换
var htmlminify = require("gulp-html-minify");
// 统一报错
var handleError = function(err) {
    var colors = gutil.colors;
    console.log('\n')
    gutil.log(colors.red('Error!'))
    gutil.log('fileName: ' + colors.red(err.fileName))
    gutil.log('lineNumber: ' + colors.red(err.lineNumber))
    gutil.log('message: ' + err.message)
    gutil.log('plugin: ' + colors.yellow(err.plugin))
}
gulp.task('uglifyjs', function() {
    var combined = combiner.obj([
        gulp.src(dir_src + '/js/**/*.js'),
        sourcemaps.init(),
        uglify(),
        sourcemaps.write('./'),
        gulp.dest('dist/min/js')
    ])
    combined.on('error', handleError)
});
gulp.task('minifycss', function() {
    gulp.src(dir_src + '/css/**/*.css').pipe(sourcemaps.init()).pipe(autoprefixer({
        browsers: 'last 2 versions'
    })).pipe(minifycss()).pipe(sourcemaps.write('./')).pipe(gulp.dest('dist/min/css'))
});
gulp.task('image', function() {
    // img
    gulp.src(dir_src + '/img/**/*').pipe(imagemin({
        progressive: true
    })).pipe(gulp.dest('dist/img'))
});
gulp.task('rev', function() {
    // js变换,取后置文件
    gulp.src('dist/min/js/**/*.js').pipe(rev()).pipe(gulp.dest('dist/js/')).pipe(rev.manifest({
        path: 'rev-manifest-js.json',
        merge: true,
    })).pipe(gulp.dest('dist/min/rev/'));
    // css变换,取后置文件
    gulp.src('dist/min/css/**/*.css').pipe(rev()).pipe(gulp.dest('dist/css/')).pipe(rev.manifest({
        path: 'rev-manifest-css.json',
        merge: true,
    })).pipe(gulp.dest('dist/min/rev/'));
});
gulp.task('revCollector', function() {
    gulp.src(['./dist/min/rev/*.json', dir_src + '/html/*.html']) //- 读取 rev-manifest.json 文件以及需要进行css名替换的文件
        .pipe(revCollector()) //- 执行文件内css名的替换
        .pipe(gulp.dest('dist/html/')); //- 替换后的文件输出的目录
});
gulp.task('copy', function() {
    gulp.src(dir_src + '/index.html').pipe(gulp.dest('dist/'))
    gulp.src(dir_src + '/libs/**/*').pipe(gulp.dest('dist/libs'))
});
gulp.task('html', function() {
    return gulp.src("dist/html/*.html").pipe(htmlminify()).pipe(gulp.dest("dist/html/"))
});
gulp.task('min', ['uglifyjs', 'minifycss', 'image']);
gulp.task('verctrl', ['rev', 'revCollector']);
gulp.task('default', ['min', 'verctrl', 'copy']);