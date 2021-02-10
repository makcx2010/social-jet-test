FROM nginx:alpine

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash \
    && set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

CMD ["nginx"]

EXPOSE 80 443
