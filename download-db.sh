#!/bin/sh
DATE=`date '+%Y%m%d%H%M%S'`
FOLDER=lobi-cms
DBNAME=lobi-cms
DUMPFILE="$DBNAME""_"$DATE

echo "Connecting to strato server using ssh"
ssh strato3 DUMPFILE=$DUMPFILE DBNAME=$DBNAME FOLDER=$FOLDER DATE=$DATE 'bash -s' <<'ENDSSH'
  # commands to run on remote host
  echo "Going to $FOLDER project root dir"
  cd /var/www/vhosts/$FOLDER/
  echo "Making Database dump"
  mysqldump $DBNAME > $DUMPFILE.sql
ENDSSH
echo "Downloading database dump from strato server"
scp strato3:/var/www/vhosts/$FOLDER/$DUMPFILE.sql ../$DUMPFILE.sql

echo "Importing \"../$DUMPFILE.sql\" into \"lobi-cms\" database";
mysql lobi-cms < ../$DUMPFILE.sql
