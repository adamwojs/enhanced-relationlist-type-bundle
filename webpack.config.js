const path = require('path');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const defaultPlugins = [
    new webpack.DefinePlugin({
        'process.env': {
            'NODE_ENV': '"production"'
        }
    }),
    new webpack.optimize.UglifyJsPlugin({
        compress: {
            warnings: false
        },
        output: {
            comments: false,
        },
    }),
    new UglifyJSPlugin({
        parallel: true,
        sourceMap: false,
        uglifyOptions: {
            compress: {
                drop_console: true,
            },
            ecma: 6,
        },
    }),
    new webpack.optimize.OccurrenceOrderPlugin(),
];

const defaultConfiguration = {
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
            },
        ],
    },
    externals: {
        react: {
            root: 'React',
            commonjs2: 'react',
            commonjs: 'react',
            amd: 'react',
        },
        'react-dom': {
            root: 'ReactDOM',
            commonjs2: 'react-dom',
            commonjs: 'react-dom',
            amd: 'react-dom',
        },
    },
};

module.exports = [
    Object.assign(
        {},
        {
            entry: {
                ContentEdit: './lib/js/components/content-edit.js',
                Utils: './lib/js/components/utils.js',
                ContentAttributeBaseComponent: './lib/js/components/content-edit/attribute/base-component.js',
            },
            output: {
                filename: '[name].js',
                path: path.resolve(__dirname, './bundle/Resources/public/js/dist/base'),
                library: ['IntProg', 'EnhancedRelationList', '[name]'],
                libraryTarget: 'umd',
                libraryExport: 'default',
            },
            plugins: [
                new CleanWebpackPlugin(['bundle/Resources/public/js/dist/base']),
                ...defaultPlugins,
            ],
        },
        defaultConfiguration
    ),
    Object.assign(
        {},
        {
            entry: {
                boolean: './lib/js/components/content-edit/attribute/checkbox.js',
                integer: './lib/js/components/content-edit/attribute/integer.js',
                selection: './lib/js/components/content-edit/attribute/selection.js',
                string: './lib/js/components/content-edit/attribute/string.js',
            },
            output: {
                filename: '[name].js',
                path: path.resolve(__dirname, './bundle/Resources/public/js/dist/modules/attributes'),
                library: ['IntProg', 'EnhancedRelationList', 'modules', 'attributes', '[name]'],
                libraryTarget: 'umd',
                libraryExport: 'default',
            },
            plugins: [
                new CleanWebpackPlugin(['bundle/Resources/public/js/dist/modules/attributes']),
                ...defaultPlugins,
            ],
        },
        defaultConfiguration
    ),
];
