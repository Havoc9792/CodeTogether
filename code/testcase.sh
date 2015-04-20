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


touch $testFolder/input.txt
touch $testFolder/temp.txt
touch $testFolder/error.txt
echo $input > $testFolder/input.txt
echo "MainClass : $2 \nInput : $3 \nExpectedOutput : $expectedOutput\n" >> $testFolder/temp.txt
timeout 3s java -classpath $groupFolder $mainClass 0<$testFolder/input.txt 1> $testFolder/output.txt 2> $testFolder/error.txt
status=$?
actualOutput=$(cat $testFolder/output.txt)
echo "actualOutput : $actualOutput\n" >> $testFolder/temp.txt
if [ "$status" = "124" ]
then
	echo -n "TIMEOUT"
else

	if [ "$actualOutput" = "$expectedOutput" ]
	then
		echo -n "PASS"
		echo "Result : PASS\n" >> $testFolder/temp.txt
	else
		echo -n "FAIL"
		echo "Result : FAIL\n" >> $testFolder/temp.txt
	fi
fi
