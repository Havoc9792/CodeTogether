#!/usr/bin/env sh
#echo `ls $@/*.class`
for classfile in `ls $@/*.class`; do
	#echo $classfile | cut -f 1 -d '.'
    classname=$(echo $classfile | cut -f 1 -d '.')
	#echo $classname	
    if (javap -public $classname.class | fgrep 'void main' ); then
        echo "@@@@@@@@@@$classname"
    fi
    #echo 1
done
