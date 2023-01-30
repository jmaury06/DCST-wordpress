#! /bin/bash
# For Dev Environment
if [ "$DEPLOYMENT_GROUP_NAME" == "dacast-wp-development-application-group" ]
    then
    find /home/deploy/releases -maxdepth 1 -type d -printf '%T@\t%p\n' |sort -r| tail -n +4|awk '{print $2}' |xargs rm -rf
fi
# For Stage Environment
if [ "$DEPLOYMENT_GROUP_NAME" == "dacast-wp-stage-application-group" ]
    then
    find /home/deploy/releases -maxdepth 1 -type d -printf '%T@\t%p\n' |sort -r| tail -n +4|awk '{print $2}' |xargs rm -rf
fi
if [ "$DEPLOYMENT_GROUP_NAME" == "dacast-wp-production-application-group" ]
    then
    find /home/deploy/releases -maxdepth 1 -type d -printf '%T@\t%p\n' |sort -r| tail -n +4|awk '{print $2}' |xargs rm -rf
fi
