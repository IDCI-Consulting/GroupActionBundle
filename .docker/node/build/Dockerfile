ARG NODE_VERSION
FROM node:${NODE_VERSION}-stretch

RUN apt-get update
RUN apt-get install -y curl ruby ruby-dev
RUN gem install sass

WORKDIR /usr/src/app
