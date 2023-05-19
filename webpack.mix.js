const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

/* Layout::start */
mix.sass('resources/assets/scss/app.scss', 'public/css');
mix.js('resources/assets/js/app.js', 'public/js');

mix.sass('resources/assets/scss/includes/_header.scss', 'public/css/includes/');
mix.js('resources/assets/js/includes/_header.js', 'public/js/includes/');

mix.sass('resources/assets/scss/_auth.scss', 'public/css');
mix.js('resources/assets/js/_auth.js', 'public/js');
/* Layout::end */

/* Home::start */
mix.sass('resources/assets/scss/home/_home.scss', 'public/css/home/');
mix.js('resources/assets/js/home/_home.js', 'public/js/home/');
/* Home::end */

/* Submit complain::start */
mix.sass('resources/assets/scss/complain/_submit_complain.scss', 'public/css/complain/');
mix.js('resources/assets/js/complain/_submit_complain.js', 'public/js/complain/');
/* Submit complain::end */

/* Profile::start */
mix.sass('resources/assets/scss/profile/_profile.scss', 'public/css/profile/');
mix.js('resources/assets/js/profile/_profile.js', 'public/js/profile/');
/* Profile::end */

/* Detail complain::start */
mix.sass('resources/assets/scss/complain/_detail.scss', 'public/css/complain/');
mix.js('resources/assets/js/complain/_detail.js', 'public/js/complain/');
/* Detail complain::end */

/* Home::start */
mix.sass('resources/assets/scss/post/_post.scss', 'public/css/post/');
mix.sass('resources/assets/scss/post/_detail.scss', 'public/css/post/');
mix.js('resources/assets/js/post/_post.js', 'public/js/post/');
/* Home::end */
