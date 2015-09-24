#!/bin/bash
#
# Generate the CSS files

cd `dirname $0`

lessc ../less/style.less > style.css
lessc ../less/style-header.less > style-header.css
diff -u style-header.css style.css | grep "^+" | grep -v "^+++" | cut -b 2- > style-body.css
