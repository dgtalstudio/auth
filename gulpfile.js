'use strict';

const gulp = require('gulp');

const jade = require('./gulp/jade');
const stylus = require('./gulp/stylus');

gulp.task('default', gulp.series(
	stylus.task,
	jade.task
));

gulp.task('watch', gulp.parallel(
	'default',
	stylus.watch,
	jade.watch
));
