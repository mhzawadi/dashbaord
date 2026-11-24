#!/bin/bash

RUN=0
for FILE in "$@"; do
  if [ $(echo "${FILE}"| grep -e '.css$' -e '.js$' | grep -q -v -e '\.min\.';echo $?) -eq 0 ]
  then
    echo "this file has changed ${FILE}"
    SHA=$(sha256sum --quiet ${FILE})
    OLDSHA=$(grep "${FILE}" ./HASH | awk -F '=' '{print $2}')
    if [ "$OLDSHA" != "$SHA" ]
    then
      echo "hash changed on file ${FILE}"
      sed -I '' "s/${OLDSHA}/${SHA}/" ./HASH
      RUN=1
    fi
  fi
done

echo "$RUN"
if [ $RUN -eq 1 ]
then
  VER=$(cat ./CSS_VER)
  NEXT=$(echo "$VER + 0.1" | bc -l)
  sed -I '' "s/v${VER}/v${NEXT}/" "./src/view/header.php"
  sed -I '' "s/v${VER}/v${NEXT}/" "./src/view/footer.php"
  echo "$NEXT" > ./CSS_VER
fi
