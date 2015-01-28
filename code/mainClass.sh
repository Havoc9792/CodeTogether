#!/usr/bin/env sh
for classfile in "$@/*.class"; do
    classname=$(echo $classfile | cut -f 1 -d '.')
	#echo $classname
    if javap -public $classname.class | fgrep 'void main'; then
        echo "@@@@@@@@@@$classname"
    fi
done
