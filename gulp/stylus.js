'use strict';

const join = require('path').join;
const gulp = require('gulp');
const stylus = require('gulp-stylus');
const nib = require('nib');
const rupture = require('rupture');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const lost = require('lost');
const b64 = require('postcss-inline-base64');
const watch = require('./helpers/watch');

const isDev = (process.env.NODE_ENV || 'development') === 'development';
const stylusPath = join(__dirname, '..', 'src', 'stylus');
const outPath = join(__dirname, '..', isDev ? 'dev' : 'public', 'css');

function css() {
	return gulp
		.src(join(stylusPath, '*.styl'))
		.pipe(stylus({
			use: [
				nib(),
				rupture()
			],
			compress: !isDev
		}))
		.pipe(postcss([
			autoprefixer({
				browsers: ['last 2 versions']
			}),
			b64(),
			lost()
		]))
		.pipe(gulp.dest(outPath));
}

function watchCss() {
	return watch(join(stylusPath, '**/*.styl'), css);
}

exports.task = css;
exports.watch = watchCss;
