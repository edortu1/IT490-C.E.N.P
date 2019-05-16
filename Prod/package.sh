#!/bin/bash

if [ $# -lt 1 ] ; then
	echo "Please provide version number"
	exit
elif [ $# -ge 3 ] ; then

	echo "Only put machine type and version number please"
	exit

fi

mtype=$1
version=$2
echo "Attempting to create package for "$mtype" version:"$version

cd /home/$USER/packageMaker/

if [ $mtype == 'deploy' ] ; then
	tar -cjf $mtype'_'$version.tar -C /var/www/html/kaplunk/ .

echo "Package "$mtype'_'$version" created successfully"

mv $mtype'_'$version.tar /home/$USER/versionShop/
cd /home/$USER/versionShop/

sshpass -p "Depl0y" scp $mtype'_'$version.tar deploy@192.168.1.9:/home/deploy/versions

rm $mtype'_'$version.tar
fi
