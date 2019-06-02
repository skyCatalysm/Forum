var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './public/js/app.js')


    .enableVueLoader()
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
