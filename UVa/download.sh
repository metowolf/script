#!/bin/bash
for ((volume=1;volume<=131;volume++))
do
	mkdir $volume
	cd $volume
	L=$volume*100
	R=$L+100
	for ((id=$L;id<$R;id++))
	do
		wget https://uva.onlinejudge.org/external/$volume/$id.pdf
	done
	if [ $volume -eq 9 ]
	then
		volume=99
		echo $volume
	fi
	cd ..
done
