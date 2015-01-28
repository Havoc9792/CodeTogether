#!/usr/bin/env sh
temp=0
for c in $(cat 543/input.txt)
do
temp=$((temp+1))
echo $temp
echo $c
done