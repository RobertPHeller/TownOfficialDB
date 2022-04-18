#!/bin/bash
cd `dirname $0`
version=`grep -e '<version>' TownOfficialDB.xml|sed 's|\(^.*<version>\)\(.*\)\(</version>.*$\)|\2|'`
rm -f TownOfficialDB-$version.zip
zip -r TownOfficialDB-$version.zip . -x@exclude.lst
