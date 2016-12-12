#!/bin/bash
touch errorlog
cat /dev/null > errorlog || { echo -e "\e[1;31m[Failed]\e[0m to access \e[4;34m errorlog \e[0m, please check your authorization."; exit 1; }
beginattime=$(date +%s)
for ((volume=1;volume<=131;volume++))
do
	{
		echo -e "\e[5;35m[Starting]\e[0m Volume \e[4;34m $volume \e[0m..."
        mkdir $volume
        cd $volume || { echo -e "\e[1;31m[Failed]\e[0m to access dir \e[4;34m $volume \e[0m, please check your authorization." | tee -a ../errorlog; exit 1; }
	    L="$volume*100"
    	R=$L+100
		begin=$(date +%s)
      	for ((id=L;id<R;id++))
    	do
    	{
				beginat=$(date +%s)
				echo -e "\e[5;32m[Starting]\e[0m to download \e[4;34m $id \e[0m in UVA Volume \e[4;34m $volume \e[0m..."
        	    if wget --tries=2 --timeout=45 -q https://uva.onlinejudge.org/external/$volume/$id.pdf
				then
				{
					endat=$(date +%s)
					spendat=$((endat-beginat))
					echo -e "\e[1;32m[  OK  ]\e[0m Downloaded \e[4;34m $id \e[0m in UVA Volume \e[4;34m $volume \e[0m in \e[4;36m $spendat \e[0m seconds."
				}
				else
				{
					echo -e "\e[1;31m[Failed]\e[0m to download \e[4;34m $id \e[0m in UVA Volume \e[4;34m $volume \e[0m." | tee -a ../errorlog
				}
				fi
        }&
    	done
		wait
		end=$(date +%s)
		spend=$((end-begin))
		echo -e "\e[5;35m[Finished]\e[0m Volume \e[4;34m $volume \e[0m in \e[4;36m $spend \e[0m seconds."
    	if [ $volume -eq 9 ]
    	then
	    	volume=99
        	echo $volume
	    fi
    	cd ..
    }
done
endattime=$(date +%s)
spendattime=$((endattime-beginattime))
echo -e "\e[1;32m[  OK  ]\e[0m Action Finished \e[4;34m\e[0m in \e[4;36m $spendattime \e[0m seconds."
if grep -q Failed errorlog
then
echo -e "\e[1;31m[Error Log]\e[0m"
cat errorlog
fi
exit 0