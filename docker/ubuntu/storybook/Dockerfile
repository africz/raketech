ARG  platform arm64v8
FROM ${platform}/ubuntu
ENV PROJECT_NAME ""
ENV VERSION 0.0.1
LABEL version=${VERSION}
LABEL description=${PROJECT_NAME}
ARG NODE_ENV=development
ENV NODE_ENV $NODE_ENV

ENV DEBIAN_FRONTEND=noninteractive
#install utils
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
wget nano mc vim htop procps git plocate iputils-ping lynx telnet \
net-tools nmap lsof

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
npm
RUN npm install -g n
RUN n lts
RUN npm init vite@latest
WORKDIR /var/www/html
RUN npm install @storybook/vue --save-dev
#not working
#RUN npx storybook@latest init
#RUN npx sb init --builder @storybook/builder-vite
#RUN npx sb init

#ENTRYPOINT ["/usr/local/bin/npm", "run","dev"]
EXPOSE 80



