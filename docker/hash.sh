#!/bin/bash

find ./src -name "*.min.js" |
while read FILE
do
  name=$(basename ${FILE} '.js')
  dir=$(dirname ${FILE})
  sha=$(sha256sum ${FILE})
  SHASUM=$(echo ${sha} | awk '{print $1}')
  cp "${FILE}" "${dir}/${name}.${SHASUM}.js"
  if [ $(grep -q "${name}.${SHASUM}" "./src/view/header.php";echo $?) -eq 1 ]
  then
    sed -I '' "s/${name}/${name}.${SHASUM}/" "./src/view/header.php"
  fi
done

find ./src -name "*.min.css" |
while read FILE
do
  name=$(basename ${FILE} '.css')
  dir=$(dirname ${FILE})
  sha=$(sha256sum ${FILE})
  SHASUM=$(echo ${sha} | awk '{print $1}')
  cp "${FILE}" "${dir}/${name}.${SHASUM}.css"
  if [ $(grep -q "${name}.${SHASUM}.css" "./src/view/header.php";echo $?) -eq 1 ]
  then
    sed -I '' "s/${name}/${name}.${SHASUM}/" "./src/view/header.php"
  fi
done
