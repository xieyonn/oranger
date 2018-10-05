const path = require('path')
const webpack = require('webpack')
const CleanWebpackPlugin = require('clean-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const webpackConfig = require('./webpack.base.config')

webpackConfig.mode = 'production'
webpackConfig.optimization = {
  splitChunks: {
    chunks: 'all',
    // minChunks: 1,
    name: 'common'
  },
  minimize: true,
  runtimeChunk: {
    name: 'runtime'
  }
}
webpackConfig.performance = {
  hints: false
}

webpackConfig.module.rules = (webpackConfig.module.rules || []).concat([
  {
    test: /\.css$/,
    use: ['style-loader', 'css-loader']
  },
  {
    test: /\.scss$/,
    use: ExtractTextPlugin.extract({
      use: [
        'css-loader',
        'sass-loader'
      ],
      fallback: 'style-loader'
    })
  }
])

webpackConfig.plugins = (webpackConfig.plugins || []).concat([
  new CleanWebpackPlugin(['dist'], {
    root: path.resolve(__dirname, '../')
  }),
  new ExtractTextPlugin({
    filename: 'chunk/style.[chunkhash].css',
    allChunks: true
  }),
  new webpack.HashedModuleIdsPlugin(),
  new webpack.DefinePlugin({
    'NODE_ENV': `'${process.env.NODE_ENV}'`
  })
])

module.exports = webpackConfig

