#!/bin/bash

echo "what do you want to do"
read verReq
ver=`./getPack.php $verReq`
echo "$ver"
echo "Attempting to send package "$ver" for "$verReq
cd /home/$USER/versions/
mkdir kaplunk
tar -C kaplunk -xvf $ver

if [ $verReq == "deploy" ] ; then
	rm -rf /var/www/html/kaplunk/
	rsync -r kaplunk /var/www/html/
elif [ $verReq == "testing" ] ; then
		sshpass -p "QueueA" ssh qa@192.168.1.12 'rm -rf /var/www/html/kaplunk/'
		sshpass -p "QueueA" rsync -r kaplunk qa@192.168.1.12:/var/www/html/
elif [ $verReq == "prod" ] ; then
		sshpass -p "Pr0d" ssh prod@192.168.1.8 'rm -rf /var/www/html/kaplunk/'
		sshpass -p "Pr0d" rsync -r kaplunk prod@192.168.1.8:/var/www/html/
elif [ $verReq == "rollback" ] ; then
		rm -rf /var/www/html/kaplunk/
		rsync -r tmp  /var/www/html/kaplunk/
else
	echo "unknown option: please enter deploy, testing, prod, or rollback"	
fi
rm -rf kaplunk
echo "done"

