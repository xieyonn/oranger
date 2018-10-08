const webpack = require('webpack')
const webpackConfig = require('./webpack.base.config.js')
const WebpackDevServer = require('webpack-dev-server')
const PORT = process.env.PORT || 5000

const config = require('../src/config')

webpackConfig.entry.main = (webpackConfig.entry.main || []).concat([
  `webpack-dev-server/client?http://localhost:${PORT}/`,
  'webpack/hot/dev-server',
])

const getProxyConfig = () => {
  let result = {}
  const { proxy } = config
  if (proxy) {
    Object.entries(proxy).forEach(proxyItem => {
      const proxyName = proxyItem[0]
      const proxyUrl = proxyItem[1]
      result[proxyName] = {
        target: proxyUrl,
        changeOrigin: true,
        secure: false
      }
    })
  }
  return result
}

webpackConfig.module.rules = (webpackConfig.module.rules || []).concat([
  {
    test: /\.css$/,
    use: ['style-loader', 'css-loader']
  },
  {
    test: /\.scss$/,
    // use: ['style-loader', 'css-loader', 'sass-loader']
    use: [
      {
        loader: 'style-loader'
      },
      {
        loader: 'css-loader'
      },
      {
        loader: 'sass-loader'
      }
    ]
  }
])

webpackConfig.plugins = (webpackConfig.plugins || []).concat([
  new webpack.HotModuleReplacementPlugin(),
  new webpack.DefinePlugin({
    'NODE_ENV': `'${process.env.NODE_ENV}'`
  })
])

webpackConfig.mode = 'development'

const compiler = webpack(webpackConfig)

const server = new WebpackDevServer(compiler, {
  hot: true,
  noInfo: true,
  quiet: true,
  historyApiFallback: true,
  filename: webpackConfig.output.filename,
  publicPath: webpackConfig.output.publicPath,
  stats: {
    colors: true
  },
  proxy: getProxyConfig()
})

server.listen(PORT, 'localhost', (err, result) => {
  if (err) {
    return console.log(err, result)
  }
  console.log(`server started at localhost:${PORT}`)
})
