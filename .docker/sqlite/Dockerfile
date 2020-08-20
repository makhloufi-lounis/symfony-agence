FROM alpine:latest
RUN apk add --update sqlite
RUN mkdir /sqlite
WORKDIR /sqlite
ENTRYPOINT sqlite3 sqlite.sqlite