#!/bin/bash

VER=$(cat ./CSS_VER)
NEXT=$(echo "$VER + 0.1" | bc -l)
sed -I '' "s/v${VER}/v${NEXT}/" "./src/view/header.php"
sed -I '' "s/v${VER}/v${NEXT}/" "./src/view/footer.php"
echo "$NEXT" > ./CSS_VER
