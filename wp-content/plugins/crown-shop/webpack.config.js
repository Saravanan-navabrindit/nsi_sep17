const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

const extractSass = new MiniCssExtractPlugin({
    filename: '../css/[name].min.css',
});

module.exports = {
	mode: 'production',
	entry: {
		public: './assets/src/js/public.js'
	},
	plugins: [
		extractSass,
		new WebpackNotifierPlugin({
			title: function (params) {
				return `Build status is ${params.status}`;
			},
			emoji: true,
			alwaysNotify: true
		})
	],
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin(),
			new CssMinimizerPlugin()
		],
	},
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'assets/dist/js')
	},
	devtool: 'source-map',
	externals: {
		jquery: 'jQuery'
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['babel-preset-env']
					}
				}
			},
			{
				test: /\.scss$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: true
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true
						}
					}
				]
			},
			{
				test: /\.css$/,
				loader: 'style-loader',
			},
			{
				test: /\.css$/,
				loader: 'css-loader'
			},
			{
				test: /\.(png|svg|jpg|gif)$/,
				type: 'asset/resource',
				generator: {
					filename: '../img/[hash][ext][query]'
				}
			}
		]
	}
};