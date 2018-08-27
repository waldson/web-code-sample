var Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('../../public/assets')
  .setPublicPath('/assets')
  .addEntry('js/app', './js/App.js')
  .addStyleEntry('css/app', './scss/app.scss')
  .configureBabel(function(babelConfig) {
    babelConfig.plugins.push('babel-plugin-transform-object-rest-spread');
  })
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableSassLoader()
  .enableVueLoader();

module.exports = Encore.getWebpackConfig();
