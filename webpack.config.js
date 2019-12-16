var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build')
    .setPublicPath('/build')

    .addStyleEntry('style', [
        './node_modules/bootstrap/dist/css/bootstrap.css',
        './assets/css/app.css'
    ])
    .addEntry('app', [
        './node_modules/jquery/dist/jquery.js',
        './node_modules/popper.js/dist/popper.js',
        './node_modules/bootstrap/dist/js/bootstrap.js',
        './assets/js/app.js'
    ])
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
;

module.exports = Encore.getWebpackConfig();