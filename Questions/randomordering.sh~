#! /bin/bash

for fname in *.jpg
do
mv "$fname" $(echo "$fname" | cut -f1 -s -d'.' | sha1sum | cut -f1 -d' ').jpg
done

for fname in *.png
do
mv "$fname" $(echo "$fname" | cut -f1 -s -d'.' | sha1sum | cut -f1 -d' ').png
done

for fname in *.txt
do
mv "$fname" $(echo "$fname" | cut -f1 -s -d'.' | sha1sum | cut -f1 -d' ').txt
done

for fname in *.atxt
do
mv "$fname" $(echo "$fname" | cut -f1 -s -d'.' | sha1sum | cut -f1 -d' ').atxt
done
