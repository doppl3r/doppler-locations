var gulp = require('gulp');
gulp.src(
    [
        'doppler-locations.php',
        'LICENSE.txt',
        'admin/**/*',
        'includes/**/*',
        'public/**/*'
    ], { base: './' }
).pipe(
    gulp.dest(
        'build'
    )
);