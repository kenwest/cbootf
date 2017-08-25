#!/bin/bash
#
# Generate the CSS files
#
# Prior to running this command, the dependencies are:
#     sudo apt-get install node-less yui-compressor

lessc less/style.less > css/style.css
yui-compressor css/style.css > css/style.min.css
drush cc css-js
