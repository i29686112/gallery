#!/bin/sh

if [ "$CIRCLE_BRANCH" = "master" ]; then
  git ftp push -u "$BT_FTP_ACCOUNT_DEV" -p "$BT_FTP_PASSWORD_DEV" ftp://"$BT_URL_DEV"
  echo "is dev"

fi
