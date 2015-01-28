#!/usr/bin/env sh
folder=$@

rm -r $folder/debug/
rm -rf $folder/*.class
rm -r $folder/output.txt
mkdir "$folder/debug"
touch "$folder/debug/compile.txt"
javac $folder/*.java 2> $folder/debug/compile.txt
#mv $folder/*.class $folder/debug/
chmod 777 -R "$folder/"
