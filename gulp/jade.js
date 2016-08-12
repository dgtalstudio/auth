'use strict';

const join = require('path').join;
const gulp = require('gulp');
const jade = require('gulp-jade');

const watch = require('./helpers/watch');

const isDev = (process.env.NODE_ENV || 'development') === 'development';
const jadePath = join(__dirname, '..', 'src', 'jade');
const outPath = join(__dirname, '..', isDev ? 'dev' : 'public');

function template() {
	return gulp
		.src(join(jadePath, '*.jade'))
		.pipe(jade({
			pretty: isDev,
			locals: {
				isDev
			}
		}))
		.pipe(gulp.dest(outPath));
}

function watchTemplate() {
	return watch(join(jadePath, '**/*.jade'), template);
}

exports.task = template;
exports.watch = watchTemplate;
