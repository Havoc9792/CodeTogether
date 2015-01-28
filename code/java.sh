#!/usr/bin/env sh
file=$1
rm $2/output.txt
rm $2/debug/runtime.txt
touch $2/output.txt
touch $2/debug/runtime.txt
chmod 777 $2/output.txt
chmod 777 $2/debug/runtime.txt
	

touch $2/temp.txt
touch $2/debug/errorplaceholder.txt
counter=1
for c in $(cat $2/input.txt)
do
echo $c > $2/temp.txt
echo "Result for Test Case $counter with input(s) : $c \n" >> $2/output.txt
java -classpath $2 $file 0< $2/temp.txt 1>> $2/output.txt 2> $2/debug/errorplaceholder.txt
if [ -s $2/debug/errorplaceholder.txt]
then
	cat $2/debug/errorplaceholder.txt >> $2/debug/runtime.txt
	cat $2/debug/errorplaceholder.txt >> $2/output.txt
	
fi
counter=$((counter+1))
done
rm $2/debug/errorplaceholder.txt
rm $2/temp.txt
#chown -R www-data:www-data $2
#chmod -R 777 $2