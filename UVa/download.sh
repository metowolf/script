#!/bin/bash
trap "echo -e \"\n\e[1;31m[Error]\e[0m The script is terminated unexpectedly.\" | tee -a ../errorlog" SIGINT
maxthread=20
if [ $(($1)) -gt 0 ]
then
maxthread=$(($1))
fi
touch errorlog
test -e /tmp/UVafifo.pipe && rm /tmp/UVafifo.pipe
mkfifo /tmp/UVafifo.pipe && exec 9<>/tmp/UVafifo.pipe
for ((i=0; i<maxthread; i++)); do echo -ne "\n" >&9;done
cat /dev/null > errorlog || { echo -e "\e[1;31m[Failed]\e[0m to access \e[4;34m errorlog \e[0m, please check your authorization."; exit 1; }
beginattime=$(date +%s)
echo -e "\e[1;32m[Starting]\e[0m to download with \e[4;34m $maxthread \e[0m threads."
for ((volume=1;volume<=131;volume++))
do
{
	if [ $volume -ge 10 ] && [ $volume -le 99 ]
	then
	exit 0
	fi
	echo -e "\e[5;35m[Starting]\e[0m Volume \e[4;34m $volume \e[0m..."
	mkdir $volume >&/dev/null
	cd $volume || { echo -e "\e[1;31m[Failed]\e[0m to access dir \e[4;34m $volume \e[0m, please check your authorization." | tee -a ../errorlog; exit 1; }
	L="$volume*100"
	R=$L+100
	begin=$(date +%s)
	for ((id=L;id<R;id++))
	do
	{
		read -u 9
		{
			beginat=$(date +%s)
			echo -e "\e[5;32m[Starting]\e[0m to download \e[4;34m $id \e[0m in UVa Volume \e[4;34m $volume \e[0m..."
			if wget --tries=2 --timeout=45 -q https://uva.onlinejudge.org/external/$volume/$id.pdf
			then
			{
				endat=$(date +%s)
				spendat=$((endat-beginat))
				echo -e "\e[1;32m[  OK  ]\e[0m Downloaded \e[4;34m $id \e[0m in UVa Volume \e[4;34m $volume \e[0m in \e[4;36m $spendat \e[0m seconds."
			}
			else
			{
				echo -e "\e[1;31m[Failed]\e[0m to download \e[4;34m $id \e[0m in UVa Volume \e[4;34m $volume \e[0m." | tee -a ../errorlog
			}
			fi
			echo -ne "\n" >&9
		}&
	}
	done
	wait
	end=$(date +%s)
	spend=$((end-begin))
	echo -e "\e[5;35m[Finished]\e[0m Volume \e[4;34m $volume \e[0m in \e[4;36m $spend \e[0m seconds."
	cd ..
}&
done
wait
endattime=$(date +%s)
spendattime=$((endattime-beginattime))
echo -e "\e[1;32m[  OK  ]\e[0m Action Finished \e[4;34m\e[0m in \e[4;36m $spendattime \e[0m seconds."
test -e /tmp/UVafifo.pipe && rm /tmp/UVafifo.pipe
if grep -q Failed errorlog
then
echo -e "\e[1;31m[Error Log]\e[0m"
cat errorlog
fi
exit 0