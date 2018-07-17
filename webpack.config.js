/**
 * External dependencies
 */
const webpack = require( 'webpack' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const SpritePlugin = require( 'svg-sprite-loader/plugin' );

const themeCSS = new ExtractTextPlugin( {
	filename: './public/css/app.min.css',
} );

// Configuration for the ExtractTextPlugin.
const extractConfig = {
	use: [
		{
			loader: 'raw-loader',
		},
		{
			loader: 'postcss-loader',
			options: {
				plugins: [
					require( 'autoprefixer' ),
				],
			},
		},
		{
			loader: 'sass-loader',
			query: {
				outputStyle: 'production' === process.env.NODE_ENV ? 'compressed' : 'nested',
			},
		},
	],
};

const config = {
	mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
	entry: {
		app: './resources/assets/js',
	},
	output: {
		filename: 'public/js/[name].min.js',
		path: __dirname,
	},
	module: {
		rules: [
			{
				test: /\.svg$/,
				use: [
					{
						loader: 'svg-sprite-loader',
						options: {
							extract: true,
							spriteFilename: './public/images/sprite.svg',
						},
					},
					'svgo-loader',
				],
				include: /icons/,
			},
			{
				test: /\.(png|jp(e*)g|svg)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							limit: 8000, // Convert images < 8kb to base64 strings
							name: '[name].[ext]',
							useRelativePath: true,
							outputPath: './public/',
						},
					},
				],
				exclude: /icons/,
			},
			{
				test: /.js$/,
				use: 'babel-loader',
				exclude: /node_modules/,
				include: /js/,
			},
			{
				test: /style\.scss$/,
				use: themeCSS.extract( extractConfig ),
				include: /scss/,
			},
		],
	},
	externals: {
		jquery: 'jQuery',
		$: 'jQuery',
	},
	plugins: [
		themeCSS,
		new SpritePlugin(),
		new webpack.ProvidePlugin( {
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
		} ),
	],
};

if ( config.mode !== 'production' ) {
	config.devtool = process.env.SOURCEMAP || 'source-map';
}

module.exports = config;
