#!/bin/bash
#
# Generate the CSS files
#
# Prior to running this command, the dependencies are:
#     sudo apt-get install node-less yui-compressor

cd $(dirname $0)

lessc ../less/style.less > style.css
yui-compressor style.css > style.min.css
