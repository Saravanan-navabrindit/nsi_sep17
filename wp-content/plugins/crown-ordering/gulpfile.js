

// project variables

var assetsPath = './assets/';

var sassIncludePaths = [
	assetsPath + 'css/scss'
];


// required variables

var gulp = require('gulp');
var $ = require('gulp-load-plugins')();


// tasks

gulp.task('css', function() {
	return gulp.src(assetsPath + 'css/scss/**/*.scss')
		.pipe($.sass({ includePaths: sassIncludePaths })
			.on('error', $.notify.onError({ title: 'SASS Compilation Error', message: '<%= error.message %>' })))
		.pipe($.autoprefixer({ browsers: [ 'last 2 versions', 'ie >= 9' ] }))
		.pipe($.cssnano())
		.pipe(gulp.dest(assetsPath + 'css/'))
		.pipe($.notify({ title: 'CSS Compiled Successfully', message: '<%= file.relative %>', onLast: true }))
});

gulp.task('js', function() {
	return gulp.src([ assetsPath + 'js/**/*.js', '!' + assetsPath + 'js/**/*.min.js' ])
		.pipe($.uglify())
		.on('error', $.notify.onError({ title: 'JS Minification Error', message: '<%= error.message %>' }))
		.pipe($.rename({ extname: '.min.js' }))
		.pipe(gulp.dest(assetsPath + 'js/'))
		.pipe($.notify({ title: 'JS Minified Successfully', message: '<%= file.relative %>' }));
});


// watch tasks

gulp.task('watch', function() {
	gulp.watch(assetsPath + 'css/scss/**/*.scss', ['css']);
	gulp.watch([ assetsPath + 'js/**/*.js', '!' + assetsPath + 'js/**/*.min.js' ], ['js']);
});


// default task

gulp.task('default', ['watch']);