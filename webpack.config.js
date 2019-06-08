var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './public/js/app.js')
    .addEntry('sec_register','./public/js/register.js')


    .enableSingleRuntimeChunk()
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
