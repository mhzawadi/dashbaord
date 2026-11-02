#!/bin/bash

rm -f ./HASH
touch ./HASH

find ./src -name "*.css" |
while read CSS
do
  SHA=$(sha256sum --quiet ${CSS})
  echo "${CSS}=${SHA}" >> ./HASH
done

find ./src -name "*.js" |
while read CSS
do
  SHA=$(sha256sum --quiet ${CSS})
  echo "${CSS}=${SHA}" >> ./HASH
done
