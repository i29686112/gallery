#!/bin/sh

if [ "$CIRCLE_BRANCH" = "master" ]; then
  #telegram
  sed -i 's/${TELEGRAM_BOT_API_URL}/$TELEGRAM_BOT_API_URL/g' .env
  sed -i 's/${TELEGRAM_BOT_API_KEY}/$TELEGRAM_BOT_API_KEY/g' .env
  sed -i 's/${TELEGRAM_BOT_USERNAME}/$TELEGRAM_BOT_USERNAME/g' .env
  sed -i 's/${TELEGRAM_DB_PREFIX}/$TELEGRAM_DB_PREFIX/g' .env
  sed -i 's/${TELEGRAM_ADMIN_USER_ID}/$TELEGRAM_ADMIN_USER_ID/g' .env
  sed -i 's/${TELEGRAM_API_SECRET}/$TELEGRAM_API_SECRET/g' .env

  #aws
  sed -i 's/${AWS_ACCESS_KEY_ID}/$AWS_ACCESS_KEY_ID/g' .env
  sed -i 's/${AWS_SECRET_ACCESS_KEY}/$AWS_SECRET_ACCESS_KEY/g' .env
  sed -i 's/${AWS_BUCKET}/$AWS_BUCKET/g' .env
  sed -i 's/${AWS_S3_PUBLIC_URL}/$AWS_S3_PUBLIC_URL/g' .env
  sed -i 's/${AWS_DEFAULT_REGION}/$AWS_DEFAULT_REGION/g' .env

  #redis
  sed -i 's/${REDIS_HOST}/$REDIS_HOST/g' .env
  sed -i 's/${REDIS_PASSWORD}/$REDIS_PASSWORD/g' .env
  sed -i 's/${REDIS_PORT}/$REDIS_PORT/g' .env

  #db
  sed -i 's/${DB_HOST}/$DB_HOST/g' .env
  sed -i 's/${DB_DATABASE}/$DB_DATABASE/g' .env
  sed -i 's/${DB_USERNAME}/$DB_USERNAME/g' .env
  sed -i 's/${DB_PASSWORD}/$DB_PASSWORD/g' .env

  #app
  sed -i 's/${APP_ENV}/$APP_ENV/g' .env
  sed -i 's/${APP_KEY}/$APP_KEY/g' .env
  sed -i 's/${APP_DEBUG}/$APP_DEBUG/g' .env

fi
