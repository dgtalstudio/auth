'use strict';

const join = require('path').join;
const gulp = require('gulp');

const nodePath = join(__dirname, '..', 'node_modules');
const outPath = join(__dirname, '..', 'dev');

function symlink() {
	return gulp
		.src(nodePath)
		.pipe(gulp.symlink(outPath, {overwrite: true}));
}

exports.task = symlink;
