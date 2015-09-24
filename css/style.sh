#!/bin/bash
#
# Generate the CSS files

cd `dirname $0`

lessc ../less/style.less > style.css
lessc ../less/style-header.less > style-header.css
curl -X POST -s --data-urlencode 'input@style-header.css' http://cssminifier.com/raw > style-header.min.css
diff -u style-header.css style.css | grep "^+" | grep -v "^+++" | cut -b 2- > style-body.css
