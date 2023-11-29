#!/bin/bash

exec 3<>/dev/tcp/127.0.0.1/4010
echo -e "SSSP/1.1\n" >&3    
if [ -f $1 ]; then
   echo -e "SCANFILE $1\n" >&3
else
   BASENAME="$(basename $1)"
   FULLPATH="$(find /tmp/ -name ${BASENAME})"
   echo -e "SCANFILE ${FULLPATH}\n" >&3
fi
echo -e "EXIT\n" >&3
cat <&3

exit $?
