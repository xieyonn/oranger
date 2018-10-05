DEV_CONFIG = require('./dev')
PROD_CONFIG = require('./prod')

let config = {}
const env = ''
try {
  env = NODE_ENV
} catch (e) {

}

if (env === 'dev') {
  try {
    // local覆盖本地
    let localConfig = require('./local.js')
    if (localConfig) {
      config = { ...DEV_CONFIG, ...localConfig }
    }
  } catch (e) {
  }
  config = DEV_CONFIG
} else {
  config = PROD_CONFIG
}

module.exports = config