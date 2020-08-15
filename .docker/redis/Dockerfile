FROM redis:5

RUN mkdir -p \
    /var/lib/redis \
    /var/run/redis && \
    chown redis /var/lib/redis && \
    chown redis /var/run/redis

COPY config/redis.conf /usr/local/etc/redis/redis.conf

CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]

RUN /bin/cp /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    echo 'Europe/Paris' > /etc/timezone
