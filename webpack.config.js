var Encore = require('@symfony/webpack-encore');


Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // .addEntry('js/app', './assets/js/index.js')
    .addEntry('js/site/core', './assets/site/js/index.js')
    .addEntry('js/admin/app', [
        './assets/admin/js/index.js'
    ])
    .addStyleEntry('css/site/app', './assets/site/scss/style.scss')
    .addStyleEntry('css/site/pages/home', './assets/site/scss/pages/_home.scss')
    .addStyleEntry('css/site/pages/gallery', './assets/site/scss/pages/_gallery.scss')
    .addStyleEntry('css/site/pages/description', './assets/site/scss/pages/_description.scss')

    .addStyleEntry('css/admin/app', './assets/admin/scss/style.scss')
    .addStyleEntry('css/admin/videoEdit', './assets/admin/scss/pages/_video_edit.scss')
    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
    .autoProvideVariables({
        $              : 'jquery',
        tjq            : 'jquery',
        jQuery         : 'jquery',
        'window.jQuery': 'jquery',
        'window.$'     : 'jquery',
    })
    .addLoader({
        test: /\.(htc)$/,
        use : [
            {
                loader : 'url-loader',
                options: {
                    limit: 10000, // Convert images < 8kb to base64 strings
                    name : '/[name].[hash].[ext]',
                }
            }
        ]
    })
    .enableBuildNotifications(true, function (options) {
        options.alwaysNotify = true;
        options.title = 'DONE';
    })
    .enableSingleRuntimeChunk()
    .copyFiles({
        from: './assets/site/images',

        // optional target path, relative to the output dir
        // to: 'images/[path][name].[ext]',

        // if versioning is enabled, add the file hash too
        to: 'site/images/[path][name].[hash:8].[ext]',

        // only copy files matching this pattern
        pattern: /\.(png|jpg|jpeg)$/
    })
    .configureTerserPlugin((options) => {
        // options.cache = true;
        options.extractComments = 'all';
        // options.sourceMap = true;
    })
;

let config = Encore.getWebpackConfig();
config.resolve.alias = {
    'waypoints': __dirname + '/node_modules/jquery-waypoints/waypoints.js',
    'router'   : __dirname + '/assets/js/router.js'
};
// config.devtool = 'source-map';
//
// if (!Encore.isProduction()) {
//     config.devtool = 'eval-source-map';
// }

module.exports = config;
