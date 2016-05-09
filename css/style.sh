#!/bin/bash
#
# Generate the CSS files

cd $(dirname $0)

lessc ../less/style.less > style.css
curl -X POST -s --data-urlencode 'input@style.css' http://cssminifier.com/raw > style.min.css
