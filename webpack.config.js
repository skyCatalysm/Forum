var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './public/js/app.js')


    .enableVueLoader()
;

module.exports = Encore.getWebpackConfig();
