#!/bin/bash
build_time=$(date +%Y%m%d_%H%M%S)
  if [ "$DEPLOYMENT_GROUP_NAME" == "dacast-wp-development-application-group" ]
      then
      rsync -avz --exclude 'build' --exclude 'appspec.yml' /opt/deployment/dacast/ /home/deploy/releases/$build_time
      sudo rm -rf /opt/deployment/dacast/
      sudo mkdir  /opt/deployment/dacast/
      cd /home/deploy/releases/$build_time
      ln -sf /shared-storage/files /home/deploy/releases/$build_time/wp-content/uploads
      ln -sf /shared-storage/files/backend /home/deploy/releases/$build_time/backend
      ln -sf /shared-storage/files/ewww /home/deploy/releases/$build_time/wp-content/ewww
      rm -rf /home/deploy/secret
      mkdir /home/deploy/secret
      ln -sf /shared-storage/private/.env /home/deploy/secret/.env
      chown -R deploy:deploy /home/deploy/releases/$build_time
      ln -sfn /home/deploy/releases/$build_time /home/deploy/public_html
      chown -R deploy:deploy /home/deploy/public_html
      sudo service nginx restart
      sudo service php7.4-fpm restart
   fi
   if [ "$DEPLOYMENT_GROUP_NAME" == "dacast-wp-stage-application-group" ]
       then
       rsync -avz --exclude 'build' --exclude 'appspec.yml' /opt/deployment/dacast/ /home/deploy/releases/$build_time
       sudo rm -rf /opt/deployment/dacast/
       sudo mkdir  /opt/deployment/dacast/
       cd /home/deploy/releases/$build_time
       ln -sf /shared-storage/files /home/deploy/releases/$build_time/wp-content/uploads
       ln -sf /shared-storage/files/backend /home/deploy/releases/$build_time/backend
       ln -sf /shared-storage/files/ewww /home/deploy/releases/$build_time/wp-content/ewww
       rm -rf /home/deploy/secret
       mkdir /home/deploy/secret
       ln -sf /shared-storage/private/.env /home/deploy/secret/.env
       chown -R deploy:deploy /home/deploy/releases/$build_time
       ln -sfn /home/deploy/releases/$build_time /home/deploy/public_html
       chown -R deploy:deploy /home/deploy/public_html
       sudo service nginx restart
       sudo service php7.3-fpm restart
    fi
    if [ "$DEPLOYMENT_GROUP_NAME" == "dacast-wp-production-application-group" ]
        then
        rsync -avz --exclude 'build' --exclude 'appspec.yml' /opt/deployment/dacast/ /home/deploy/releases/$build_time
        sudo rm -rf /opt/deployment/dacast/
        sudo mkdir  /opt/deployment/dacast/
        cd /home/deploy/releases/$build_time
        ln -sf /shared-storage/files /home/deploy/releases/$build_time/wp-content/uploads
        ln -sf /shared-storage/files/backend /home/deploy/releases/$build_time/backend
        ln -sf /shared-storage/files/ewww /home/deploy/releases/$build_time/wp-content/ewww
        rm -rf /home/deploy/secret
        mkdir /home/deploy/secret
        ln -sf /shared-storage/private/.env /home/deploy/secret/.env
        chown -R deploy:deploy /home/deploy/releases/$build_time
        ln -sfn /home/deploy/releases/$build_time /home/deploy/public_html
        chown -R deploy:deploy /home/deploy/public_html
        sudo service nginx restart
        sudo service php7.4-fpm restart
     fi
