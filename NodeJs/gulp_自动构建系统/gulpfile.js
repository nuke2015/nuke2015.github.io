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
        gulp.src('../static/js/**/*.js'),
        sourcemaps.init(),
        uglify(),
        sourcemaps.write('./'),
        gulp.dest('dist/js/')
    ])
    combined.on('error', handleError)
});
gulp.task('minifycss', function() {
    gulp.src('../static/css/**/*.css').pipe(sourcemaps.init()).pipe(autoprefixer({
        browsers: 'last 2 versions'
    })).pipe(minifycss()).pipe(sourcemaps.write('./')).pipe(gulp.dest('dist/css/'))
});
gulp.task('image', function() {
    // images
    gulp.src('../static/images/**/*').pipe(imagemin({
            progressive: true
        })).pipe(gulp.dest('dist/images'))
        // icon
    gulp.src('../static/icon/**/*').pipe(imagemin({
            progressive: true
        })).pipe(gulp.dest('dist/icon'))
        // img
    gulp.src('../static/img/**/*').pipe(imagemin({
        progressive: true
    })).pipe(gulp.dest('dist/img'))
});
gulp.task('rev', function() {
    // js变换
    gulp.src('../static/js/**/*.js').pipe(rev()).pipe(gulp.dest('./dist/js/')).pipe(rev.manifest({
        path: 'rev-manifest-js.json',
        merge: true,
    })).pipe(gulp.dest('./dist/rev/'));
    // css变换
    gulp.src('../static/css/**/*.css').pipe(rev()).pipe(gulp.dest('./dist/css/')).pipe(rev.manifest({
        path: 'rev-manifest-cs.json',
        merge: true,
    })).pipe(gulp.dest('./dist/rev/'));
});
gulp.task('revCollector', function() {
    gulp.src(['./dist/rev/*.json', '../static/html/*.html']) //- 读取 rev-manifest.json 文件以及需要进行css名替换的文件
        .pipe(revCollector()) //- 执行文件内css名的替换
        .pipe(gulp.dest('dist/html/')); //- 替换后的文件输出的目录
});
gulp.task('verctrl', ['rev', 'revCollector']);
gulp.task('default', ['uglifyjs', 'minifycss', 'image', 'verctrl']);