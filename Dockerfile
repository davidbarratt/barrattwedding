# Builder
FROM composer as builder

# All of the Environment Arguments can be used.
ARG SYMFONY_ENV=prod
ARG SYMFONY_DEBUG=0
ARG SYMFONY__SECRET=6b91251b5855897443ec29a12c8b1aa5
ARG SYMFONY__DATABASE_URL=sqlite:///%kernel.root_dir%/../app/data/data.db
ARG SYMFONY__MAILER_URL
ARG SYMFONY__WEDDING_TWITTER__TWITTER__CONSUMER_KEY
ARG SYMFONY__WEDDING_TWITTER__TWITTER__CONSUMER_SECRET
ARG SYMFONY__WEDDING_TWITTER__TWITTER__ACCESS_KEY
ARG SYMFONY__WEDDING_TWITTER__TWITTER__ACCESS_KEY_SECRET

COPY ./ /app

RUN composer --no-dev install

RUN /app/app/console assetic:dump

# Service
FROM davidbarratt/php:5.6

# All of the Environment Arguments can be used.
ARG SYMFONY_ENV=prod
ARG SYMFONY_DEBUG=0
ARG SYMFONY__SECRET=6b91251b5855897443ec29a12c8b1aa5
ARG SYMFONY__DATABASE_URL=sqlite:///%kernel.root_dir%/../app/data/data.db
ARG SYMFONY__MAILER_URL
ARG SYMFONY__WEDDING_TWITTER__TWITTER__CONSUMER_KEY
ARG SYMFONY__WEDDING_TWITTER__TWITTER__CONSUMER_SECRET
ARG SYMFONY__WEDDING_TWITTER__TWITTER__ACCESS_KEY
ARG SYMFONY__WEDDING_TWITTER__TWITTER__ACCESS_KEY_SECRET

# Copy the app and all the dependencies
COPY --from=builder /app /var/www

# Add the Composer bin to the PATH
ENV PATH="/var/www/vendor/bin:${PATH}"

# Touch the SQLite Database and set the permissions
RUN mkdir -p ../app/data \
    && touch ../app/data/data.db \
    && chown -R www-data:www-data ../app/data

# Clear the cache & Create the database schema
RUN ../app/console cache:clear \
  && chown -R www-data:www-data ../app/logs \
  && chown -R www-data:www-data ../app/cache \
  && ../app/console doctrine:schema:create
