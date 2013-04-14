#! /bin/bash

for f in *.a.txt; do
mv -- "$f" "${f%.a.txt}.atxt"
done
