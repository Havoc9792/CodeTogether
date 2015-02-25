#!/usr/bin/env sh
groupFolder=$1
testFolder=$1/testcase
mainClass=$2
input=$3
expectedOutput=$4
rm $testFolder -rf
mkdir $testFolder
touch $testFolder/output.txt
touch $testFolder/runtime.txt
chmod 777 $testFolder/output.txt
chmod 777 $testFolder/runtime.txt


touch $testFolder/temp.txt
touch $testFolder/error.txt

timeout 2s java -classpath $groupFolder $mainClass $input 1> $testFolder/output.txt 2> $testFolder/error.txt;

actualOuput=$(cat $testFolder/output.txt)
if(-z "$actualOuput")
then
	echo -n "TIMEOUT"
else

	if("$actualOuput" == "$expectedOuput")
	then
		echo -n "PASS"
	else
		echo -n "FAIL"
	fi
fi
