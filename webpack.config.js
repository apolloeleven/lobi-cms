const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
  entry: {
    app: [
      path.resolve(__dirname, './frontend/web/js/app.js'),
      path.resolve(__dirname, './frontend/web/js/content-editable/app.js'),
    ],
    style: path.resolve(__dirname, './frontend/less/style.less'),
    bootstrap: path.resolve(__dirname, './frontend/less/bootstrap.less'),
    ckeditor: [
      path.resolve(__dirname, './frontend/less/ckeditor.less'),
      path.resolve(__dirname, './frontend/less/xmlblock.less'),
    ],
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, './frontend/web/bundle'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: [/node_modules/],
        use: [
          {
            loader: 'babel-loader',
            options: {presets: ['latest']}
          }
        ]
      },
      {
        test: /\.less$/,
        use: ExtractTextPlugin.extract({
          use: [
            {loader: 'css-loader', options: {minimize: true, sourceMap: true}},
            {
              loader: "less-loader",
              options: {
                minimize: true,
                sourceMap: true
              }
            }
          ]
        })
      },
      {
        test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: 'fonts/'
          }
        }]
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin({
      filename: "[name].css",
      allChunks: true
    })
  ],
  devtool: 'source-map'
};
