let mix = require('laravel-mix')
require('dotenv').config()

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
const VueLoaderPlugin = require('vue-loader/lib/plugin')

mix
	.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.copy('resources/assets/img/', 'public/img/', false)
	.sourceMaps()
	.disableNotifications()
	.browserSync(process.env.APP_URL)
	.webpackConfig(webpack => {
		return {
			plugins: [
				new VueLoaderPlugin()
			],
			module: {
				rules: [
					{
						test: /\.pug$/,
						loader: 'pug-plain-loader',
					},
				],
			},
			resolve: {
				alias: {
					Vue: path.join(__dirname, 'node_modules/vue'),
				}
			},
		}
	})