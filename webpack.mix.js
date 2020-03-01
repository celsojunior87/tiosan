const path = require('path')
const mix = require('laravel-mix')
const connect = require('gulp-connect-php')

mix.config.vue.esModule = true

connect.server({
  base: './public',
  port: 8000,
  keepalive: true
});

mix.sass('resources/sass/app.scss', 'public/css')

mix.js('resources/js/app.js', 'public/js');

mix
    .sourceMaps()
    .browserSync({
      proxy: "localhost:8000",
    });

mix.options({ processCssUrls: false });

mix.webpackConfig({
  watchOptions: {
    ignored: /node_modules/
  },
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/'
  }
})
