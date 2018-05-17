const {mix} = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
var vendors = 'node_modules/';

var resourcesAssets = 'resources/assets/';
var srcCss = resourcesAssets + 'css/';
var srcJs = resourcesAssets + 'js/';

var dest = 'public/';
var destFonts = dest + 'fonts/';
var destCss = dest + 'css/';
var destJs = dest + 'js/';
var destImg = dest + 'img/';

var paths = {
    'jquery': vendors + 'jquery/dist',
    'jqueryUi': vendors + 'jquery-ui',
    'bootstrap': vendors + 'bootstrap/dist',
    'dataTables': vendors + 'datatables/media',
    'fontawesome': vendors + 'font-awesome',
    'animate': vendors + 'animate.css',
    'daterangepicker': vendors + 'bootstrap-daterangepicker',
    'fileinput': vendors + 'bootstrap-fileinput',
    'select': vendors + 'bootstrap-select/dist',
    'fullcalendar': vendors + 'fullcalendar/dist',
    'icheck': vendors + 'icheck',
    'eonasdanBootstrapDatetimepicker': vendors + 'eonasdan-bootstrap-datetimepicker/build',
    'moment': vendors + 'moment/min',
    'noty': vendors + 'noty/js/noty',
    'select2': vendors + 'select2/dist',
    'toastr': vendors + 'toastr',
    'verticaltimeline': vendors + 'vertical-timeline',
    'ekko-lightbox': vendors + 'ekko-lightbox/',
    'select2BootstrapTheme': vendors + 'select2-bootstrap-theme/dist',
    'underscore': vendors + 'underscore',
    'jasnyBootstrap': vendors + 'jasny-bootstrap/dist',
    'summernote': vendors + '/summernote/dist',
    'intlTelInput': vendors + '/intl-tel-input/build',
    'jQuerySimpleTimer': vendors + '/jQuery-Simple-Timer',
    'tokenfield': vendors + '/bootstrap-tokenfield/dist',
    'bootstrapColorpicker': vendors + '/bootstrap-colorpicker/dist',
    'bootstrapRtl': vendors + '/bootstrap-rtl/dist',
    'metismenu': vendors + '/metismenu/dist'
};
mix.combine(
    [
        paths.metismenu + '/metisMenu.css',
        srcCss + 'sms.css',
        srcCss + 'custom.css'
    ], destCss + 'sms.css');

mix.combine(
    [
        paths.metismenu + '/metisMenu.js',
        srcJs + 'sms.js',
        srcJs + 'custom.js'
    ], destJs + 'sms.js');

// install
mix.copy(resourcesAssets + '/css/install.css', destCss + 'install.css');
// frontend
mix.copy(resourcesAssets + '/css/frontend_sms.css', destCss + 'frontend_sms.css');

// Copy fonts straight to public
mix.copy(vendors + '/bootstrap/fonts', destFonts);
mix.copy(vendors + '/font-awesome/fonts', destFonts);
mix.copy(resourcesAssets + '/css/material-design-icons/iconfont', destFonts);
mix.copy(vendors + '/summernote/dist/font', destCss + '/font');

// Copy images straight to public
mix.copy(vendors + '/bootstrap-fileinput/img', destImg);
mix.copy(vendors + '/jquery-ui/themes/base/images', destImg);
mix.copy(vendors + '/jquery-ui/themes/base/images', destCss + '/images');
mix.copy(vendors + '/datatables/media/images', destImg);
mix.copy(vendors + '/intl-tel-input/build/img', destImg);
mix.copy(vendors + '/bootstrap-fileinput/img', destImg);
mix.copy(resourcesAssets + '/images', destImg);
mix.copy(resourcesAssets + '/avatar', 'public/uploads/avatar');
mix.copy(resourcesAssets + '/logo', 'public/uploads/site');
mix.copy(vendors + '/bootstrap-colorpicker/dist/img', destImg);
mix.copy(paths.icheck + '/skins/minimal', destImg+'/icheck');
mix.copy(paths.icheck + '/skins/minimal/*.png', destCss);

mix.copy(resourcesAssets + '/js/sms_app.js', destJs);
mix.copy(resourcesAssets + '/js/countUp.min.js', destJs);
mix.copy(resourcesAssets + '/js/d3.min.js', destJs);
mix.copy(resourcesAssets + '/js/d3.v3.min.js', destJs);
mix.copy(resourcesAssets + '/js/d3.v3.min.js', destJs);
//icheck;
mix.copy(paths.icheck + '/icheck.min.js', destJs);
mix.copy(paths.icheck + '/skins/minimal/_all.css', destCss + 'icheck.css');
//c3 chart css and js files
mix.copy(vendors + '/c3/c3.min.css', destCss);
mix.copy(vendors + '/c3/c3.min.js', destJs);

mix.copy(vendors + '/jQuery-Simple-Timer/jquery.simple.timer.js', destJs);

mix.copy('resources/assets/js/todolist.js', 'public/js');
mix.copy('resources/assets/js/todolist_admin.js', 'public/js');

//favicon
mix.copy(resourcesAssets + '/favicon', dest);

//Mix styles for login page
mix.combine(
    [
        paths.bootstrap + '/css/bootstrap-theme.css',
        paths.fontawesome + '/css/font-awesome.css',
        paths.intlTelInput + '/css/intlTelInput.css',
        paths.icheck + '/skins/minimal/_all.css'
    ],
    destCss + 'login.css');

//RTL login
mix.combine(
    [
        paths.bootstrap + '/css/bootstrap-theme.css',
        paths.fontawesome + '/css/font-awesome.css',
        paths.icheck + '/skins/minimal/_all.css',
        paths.intlTelInput + '/css/intlTelInput.css',
        paths.bootstrapRtl + '/css/bootstrap-rtl.css',
        paths.bootstrapRtl + '/css/bootstrap-flipped.css'
    ]
    , destCss + 'rtl_login.css');

//Mix scripts for login page
mix.combine(
    [
        paths.jquery + '/jquery.js',
        paths.bootstrap + '/js/bootstrap.min.js',
        paths.intlTelInput + '/js/intlTelInput.js',
        paths.intlTelInput + '/js/utils.js',
        srcJs + 'login.js'
    ]
    , destJs + 'login.js');

//Mix global frontend styles
mix.combine(
    [
        paths.fontawesome + '/css/font-awesome.css',
        paths.jqueryUi + '/themes/smoothness/jquery-ui.css',
        paths.bootstrap + '/css/bootstrap.css',
        srcCss + 'frontend.css'
    ]
    , destCss + 'libs_frontend.css');

//RTL support frontend
mix.combine(
    [
        paths.fontawesome + '/css/font-awesome.css',
        paths.jqueryUi + '/themes/smoothness/jquery-ui.css',
        paths.bootstrap + '/css/bootstrap.css',
        paths.bootstrapRtl + '/css/bootstrap-rtl.css',
        paths.bootstrapRtl + '/css/bootstrap-flipped.css',
        srcCss + 'frontend.css'
    ]
    , destCss + 'rtl_libs_frontend.css');

//Mix scripts frontend styles
mix.combine(
    [
        paths.jquery + '/jquery.js',
        paths.jqueryUi + '/jquery-ui.min.js',
        paths.bootstrap + '/js/bootstrap.min.js'
    ]
    , destJs + 'libs_frontend.js');

//Mix global styles
mix.combine(
    [
        paths.fontawesome + '/css/font-awesome.css',
        paths.bootstrap + '/css/bootstrap.css',
        paths.dataTables + '/css/dataTables.css',
        paths.dataTables + '/css/dataTables.bootstrap.css',
        paths.animate + '/animate.min.css',
        paths.eonasdanBootstrapDatetimepicker + '/css/bootstrap-datetimepicker.css',
        paths.fileinput + '/css/fileinput.min.css',
        paths.select + '/css/bootstrap-select.min.css',
        paths.fullcalendar + '/fullcalendar.min.css',
        paths.select2BootstrapTheme + '/select2-bootstrap.min.css',
        paths.select2 + '/css/select2.min.css',
        paths.toastr + '/toastr.min.css',
        paths.jasnyBootstrap + '/css/jasny-bootstrap.min.css',
        paths.jqueryUi + '/themes/cupertino/jquery-ui.css',
        paths.summernote + '/summernote.css',
        paths.intlTelInput + '/css/intlTelInput.css',
        paths.bootstrapColorpicker + '/css/bootstrap-colorpicker.css',
        paths.tokenfield + '/css/bootstrap-tokenfield.css',
        //'panel.css',
        srcCss + 'material-design-icons/material-design-icons.css'
    ]
    , destCss + 'libs.css');
//RTL support
mix.combine(
    [
        paths.fontawesome + '/css/font-awesome.css',
        paths.bootstrap + '/css/bootstrap.css',
        paths.dataTables + '/css/dataTables.css',
        paths.dataTables + '/css/dataTables.bootstrap.css',
        paths.animate + '/animate.min.css',
        paths.eonasdanBootstrapDatetimepicker + '/css/bootstrap-datetimepicker.css',
        paths.fileinput + '/css/fileinput.min.css',
        paths.select + '/css/bootstrap-select.min.css',
        paths.fullcalendar + '/fullcalendar.min.css',
        paths.select2BootstrapTheme + '/select2-bootstrap.min.css',
        paths.select2 + '/css/select2.min.css',
        paths.toastr + '/toastr.min.css',
        paths.jasnyBootstrap + '/css/jasny-bootstrap.min.css',
        paths.jqueryUi + '/themes/cupertino/jquery-ui.css',
        paths.summernote + '/summernote.css',
        paths.intlTelInput + '/css/intlTelInput.css',
        paths.bootstrapColorpicker + '/css/bootstrap-colorpicker.css',
        paths.bootstrapRtl + '/css/bootstrap-rtl.css',
        paths.tokenfield + '/css/bootstrap-tokenfield.css',
        paths.bootstrapRtl + '/css/bootstrap-flipped.css',
        //'panel.css',
        srcCss + 'material-design-icons/material-design-icons.css'
    ]
    , destCss + 'rtl_libs.css');

//Mix global scripts
mix.combine(
    [
        paths.jquery + '/jquery.js',
        srcJs + '/jquery-ui.min.js',
        paths.moment + '/moment-with-locales.js',
        paths.bootstrap + '/js/bootstrap.min.js',
        paths.dataTables + '/js/jquery.dataTables.js',
        paths.dataTables + '/js/dataTables.bootstrap.js',
        paths.eonasdanBootstrapDatetimepicker + '/js/bootstrap-datetimepicker.min.js',
        paths.fileinput + '/js/fileinput.min.js',
        paths.select + '/js/bootstrap-select.min.js',
        paths.fullcalendar + '/fullcalendar.js',
        paths.noty + '/jquery.noty.js',
        paths.select2 + '/js/select2.min.js',
        paths.toastr + '/toastr.min.js',
        paths.jasnyBootstrap + '/js/jasny-bootstrap.js',
        paths.underscore + '/underscore-min.js',
        paths.summernote + '/summernote.js',
        paths.intlTelInput + '/js/intlTelInput.js',
        paths.intlTelInput + '/js/utils.js',
        srcJs + 'formValidation.min.js',
        paths.jQuerySimpleTimer + '/jquery.simple.timer.js',
        paths.tokenfield + '/bootstrap-tokenfield.js',
        paths.bootstrapColorpicker + '/js/bootstrap-colorpicker.js',
        srcJs + 'palette.js'
    ]
    , destJs + 'libs.js');