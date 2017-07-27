#!/bin/bash


case "$1" in
	paring)
		echo -e "agent on\n" 

		echo -e "scan on\n" 

		sleep 3	

		echo -e "pair $2" 

		sleep 2

		echo -e "$3\n" 

                echo -e "quit\n" 
		;;

	remove)
		echo -e "remove $2\n"

		echo -e "quit\n"
		;;
	status)
	        echo -e "devices\n"
		
		echo -e "quit\n"
		;;
	paireds)
		echo -e "paired-devices\n"

		echo -e "quit\n"
		;;
	*)
		echo "invalid  option"
		;;
esac

exit 0
