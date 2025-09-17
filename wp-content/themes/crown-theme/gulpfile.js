

// project variables

var assetsPath = './assets';

var assetsSassIncludePaths = [
	assetsPath + '/src/scss'
];


// required variables

var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
const sass = require('gulp-sass')(require('sass'));


// core tasks

gulp.task('css:style', function() {
	return gulp.src(assetsPath + '/src/scss/style.scss')
		.pipe($.sourcemaps.init())
		.pipe(sass({ includePaths: assetsSassIncludePaths })
			.on('error', $.notify.onError({ title: 'SASS Compilation Error', message: '<%= error.message %>' })))
		.pipe($.autoprefixer({ overrideBrowserslist: [ 'last 2 versions', 'ie >= 9' ] }))
		.pipe(gulp.dest(assetsPath + '/css/'))
		.pipe($.cssnano())
		.pipe($.rename({ extname: '.min.css' }))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest(assetsPath + '/css/'))
		.pipe($.notify({ title: 'CSS Compiled Successfully', message: '<%= file.relative %>', onLast: true }))
});

gulp.task('css:editor-style', function() {
	return gulp.src(assetsPath + '/src/scss/editor-style.scss')
		.pipe($.sourcemaps.init())
		.pipe(sass({ includePaths: assetsSassIncludePaths })
			.on('error', $.notify.onError({ title: 'SASS Compilation Error', message: '<%= error.message %>' })))
		.pipe($.autoprefixer({ overrideBrowserslist: [ 'last 2 versions', 'ie >= 9' ] }))
		.pipe(gulp.dest(assetsPath + '/css/'))
		.pipe($.cssnano())
		.pipe($.rename({ extname: '.min.css' }))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest(assetsPath + '/css/'))
		.pipe($.notify({ title: 'CSS Compiled Successfully', message: '<%= file.relative %>', onLast: true }))
});

gulp.task('js:main', function() {
	return gulp.src([ assetsPath + '/src/js/main.js' ])
		.pipe(gulp.dest(assetsPath + '/js/'))
		.pipe($.uglify())
		.on('error', $.notify.onError({ title: 'JS Minification Error', message: '<%= error.message %>' }))
		.pipe($.rename({ extname: '.min.js' }))
		.pipe(gulp.dest(assetsPath + '/js/'))
		.pipe($.notify({ title: 'JS Minified Successfully', message: '<%= file.relative %>' }));
});

gulp.task('js:block-editor', function() {
	return gulp.src([ assetsPath + '/src/js/block-editor.js' ])
		.pipe(gulp.dest(assetsPath + '/js/'))
		.pipe($.uglify())
		.on('error', $.notify.onError({ title: 'JS Minification Error', message: '<%= error.message %>' }))
		.pipe($.rename({ extname: '.min.js' }))
		.pipe(gulp.dest(assetsPath + '/js/'))
		.pipe($.notify({ title: 'JS Minified Successfully', message: '<%= file.relative %>' }));
});


// watch tasks

gulp.task('watch', function() {
	gulp.watch(assetsPath + '/src/scss/*/*.scss', gulp.series('css:style'));
	gulp.watch(assetsPath + '/src/scss/style.scss', gulp.series('css:style'));
	gulp.watch(assetsPath + '/src/scss/editor-style.scss', gulp.series('css:editor-style'));
	gulp.watch(assetsPath + '/src/js/main.js', gulp.series('js:main'));
	gulp.watch(assetsPath + '/src/js/block-editor.js', gulp.series('js:block-editor'));
});


// default task

gulp.task('default', gulp.series('watch', function() {}));