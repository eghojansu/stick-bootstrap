#!/bin/bash

if [ -z "$1" ] ; then
    echo "Please provide version number!"
    exit
fi

DESTINATION='/home/fal/Temp/dist'
CURRENT_DIR=$PWD
SELF=${0##*/}
DIRNAME=${PWD##*/}
ZIPFILE="${DESTINATION}/${DIRNAME}-${1}.zip"

cd ..

# Zip this directory
zip -r9 $ZIPFILE $DIRNAME --exclude \
    "*/.git/*"  \
    "${DIRNAME}/var/*"  \
    "${DIRNAME}/xdev/*" \
    "${DIRNAME}/.env" \
    "${DIRNAME}/.php_cs.cache" \
    "${DIRNAME}/${SELF}" \
    "${DIRNAME}/public/assets/bootstrap/css/bootstrap.min.css.map"

# removing files
# zip -d $ZIPFILE "${DIRNAME}/${SELF}"

cd $CURRENT_DIR

echo "Zipping done (${ZIPFILE})"