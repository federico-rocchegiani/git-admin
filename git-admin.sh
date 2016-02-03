#!/bin/bash

if [ $(whoami) != "root" ]; then
    echo "Please run command with sudo."
    exit;
fi

# http://stackoverflow.com/a/246128
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
export RES=$DIR"/res"

case "$1" in
  start)
        httpd -f $RES/httpd.conf -k start
        ;;
  stop)
        httpd -f $RES/httpd.conf -k stop
        ;;
  *)
        echo $"Usage: $0 {start|stop}"
esac
