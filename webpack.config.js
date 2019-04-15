var webpack = require('webpack');
var path    = require('path');

module.exports = {
  entry: {
    'main': './Resources/public/js/src/main.js'
  },
  output: {
    path: __dirname + '/Resources/public/js/dist',
    filename: '[name].js',
    publicPath: "/bundles/idcigroupaction/js/dist/"
  },
  resolve: {
    alias: {
      'IDCIGroupActionBundle': path.resolve(__dirname, 'Resources/public/js/src/')
    }
  },
  devtool: 'source-map',
  module: {
    rules: [
      {
        test: /\.js$/,
        use: [{
          loader: 'babel-loader',
          options: {
            presets: ['env']
          }
        }]
      }
    ]
  }
};

if (process.env.NODE_ENV === 'production') {
  module.exports.plugins = (module.exports.plugins || []).concat([
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"production"'
      }
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    }),
    new webpack.LoaderOptionsPlugin({
      minimize: true
    })
  ])
}
