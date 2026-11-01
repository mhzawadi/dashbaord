#!/bin/bash

RUN=0
for FILE in "$@"; do
  if [ $(echo "${FILE}"| grep -e '.css$' -e '.js$' | grep -q -v -e '\.min\.';echo $?) -eq 0 ]
  then
    echo "this file has changed ${FILE}"
    SHA=$(sha256sum --quiet ${FILE})
    if [ $(grep -q "${SHA}" HASH;echo $?) -eq 1  ]
    then
      echo "hash changed on file ${FILE}"
      sed -I '' "s!^${FILE}.*!${FILE}=${SHA}!" HASH
      RUN=1
    fi
  fi
done

if [ $RUN -eq 1 ]
then
  VER=$(cat ./CSS_VER)
  NEXT=$(echo "$VER + 0.1" | bc -l)
  sed -I '' "s/v${VER}/v${NEXT}/" "./src/view/header.php"
  sed -I '' "s/v${VER}/v${NEXT}/" "./src/view/footer.php"
  echo "$NEXT" > ./CSS_VER
fi
