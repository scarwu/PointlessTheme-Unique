var path = require('path');

module.exports = {
    entry: './assets/scripts/main.jsx',
    output: {
        filename: 'main.min.js'
    },
    resolve: {
        root: path.resolve('./src/assets/scripts'),
        extensions: ['', '.js', '.jsx']
    },
    externals: {},
    module: {
        loaders: [
            {
                test: /.jsx?$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react']
                }
            }
        ]
    }
}
