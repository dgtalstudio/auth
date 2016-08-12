'use strict';

const join = require('path').join;
const gulp = require('gulp');

const srcPath = join(__dirname, '..', 'dev');
const outPath = join(__dirname, '..', 'public');

function copy(src, dest) {
	return gulp
		.src(join(srcPath, src))
		.pipe(gulp.dest(join(outPath, dest)));
}

exports.task = copy;
