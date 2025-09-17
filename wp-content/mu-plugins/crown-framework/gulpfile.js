

// project variables

var crownPath = './src/Resources/Public/';

var crownSassIncludePaths = [
	crownPath + 'css/scss'
];


// required variables

var gulp = require('gulp');
var $ = require('gulp-load-plugins')();


// crown tasks

gulp.task('crown:css', function() {
	return gulp.src(crownPath + 'css/scss/**/*.scss')
		.pipe($.sass({ includePaths: crownSassIncludePaths })
			.on('error', $.notify.onError({ title: 'SASS Compilation Error', message: '<%= error.message %>' })))
		.pipe($.autoprefixer({ browsers: [ 'last 2 versions', 'ie >= 9' ] }))
		.pipe($.cssnano())
		.pipe(gulp.dest(crownPath + 'css/'))
		.pipe($.notify({ title: 'CSS Compiled Successfully', message: '<%= file.relative %>', onLast: true }))
});

gulp.task('crown:js', function() {
	return gulp.src([ crownPath + 'js/**/*.js', '!' + crownPath + 'js/**/*.min.js' ])
		.pipe($.uglify())
		.on('error', $.notify.onError({ title: 'JS Minification Error', message: '<%= error.message %>' }))
		.pipe($.rename({ extname: '.min.js' }))
		.pipe(gulp.dest(crownPath + 'js/'))
		.pipe($.notify({ title: 'JS Minified Successfully', message: '<%= file.relative %>' }));
});


// watch tasks

gulp.task('watch', function() {
	gulp.watch(crownPath + 'css/scss/**/*.scss', gulp.series('crown:css'));
	gulp.watch([ crownPath + 'js/**/*.js', '!' + crownPath + 'js/**/*.min.js' ], gulp.series('crown:js'));
});


// default task

gulp.task('default', gulp.series('watch', function() {}));