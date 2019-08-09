const webpack = require( 'webpack' ); // WebPack module
const CopyWebpackPlugin = require( 'copy-webpack-plugin' ); // command to copy files
const path = require( 'path' ); // for path
const inProduction = ('production' === process.env.NODE_ENV); // if in production
const ImageminPlugin = require( 'imagemin-webpack-plugin' ).default; // Optimize images
const CleanWebpackPlugin = require( 'clean-webpack-plugin' ); // To clean (remove files)
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' ); // for RTL support (optional)
const wpPot = require( 'wp-pot' ); // For creating .pot files
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");

const config = {
    // Ensure modules like magnific know jQuery is external (loaded via WP).
    externals: {
        $: 'jQuery',
        jquery: 'jQuery'
    },
    devtool: 'source-map',
    module: {
        rules: [

            // Use Babel to compile JS.
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loaders: [
                    'babel-loader'
                ]
            },

            // Create RTL styles.
            {
                test: /\.css$/,
                loader: MiniCssExtractPlugin.loader
            },

            // SASS to CSS.
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true
                        }
                    }, {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            outputStyle: (inProduction ? 'compressed' : 'nested')
                        }
                    }
                ]
            },

            // Image files.
            {
                test: /\.(png|jpe?g|gif|svg)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'images/[name].[ext]',
                            publicPath: '../'
                        }
                    }
                ]
            }
        ]
    },

    plugins: [
        // Removes the "dist" folder before building.
        new CleanWebpackPlugin( [ 'assets/dist' ] ),

        new MiniCssExtractPlugin({
            filename: "css/[name].css",
            chunkFilename: "[id].css"
        }),

        // Create RTL css.
        new WebpackRTLPlugin()
    ]
};

if ( inProduction ) {

    // POT file.
    wpPot( {
        package: 'wp-sponsors',
        domain: 'wp-sponsors',
        destFile: 'languages/wp-sponsors.pot',
        relativeTo: './',
    } );

    config.optimization = {
        minimizer: [
            new UglifyJsPlugin({
                cache: true,
                parallel: true,
                sourceMap: true // set to true if you want JS source maps
            }),
            new OptimizeCSSAssetsPlugin({})
        ]
    };
}

module.exports = [
    // Adding entry points and output to the config.
    Object.assign({
        entry: {
            'public': ['./assets/css/public.scss', './assets/js/public.js'],
            'admin': ['./assets/css/admin.scss', './assets/js/admin.js']
        },
        output: {
            path: path.join( __dirname, './assets/dist/' ),
            filename: 'js/[name].js',
        },
    }, config),
    // Adding our blocks JS as gutenberg.js and babel polyfill.
    Object.assign({
        entry: {
            'babel-polyfill': 'babel-polyfill',
            'gutenberg': ['./assets/css/blocks.scss', './assets/js/blocks.js'],
        },

        // Tell webpack where to output.
        output: {
            path: path.resolve( __dirname, './assets/dist/' ),
            filename: 'js/[name].js'
        },
    }, config)
];