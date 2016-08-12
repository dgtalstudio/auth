'use strict';

const gulp = require('gulp');
const logger = require('gulplog');

function watch(glob, task) {
	return gulp
		.watch(glob, task)
		.on('change', path => {
			logger.info(`File ${path} was changed`);
		});
}

module.exports = watch;
