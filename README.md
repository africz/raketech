# Get the source code
git clone git@github.com:africz/raketech.git
Make sure docker desktop is running
I did test with Mac and Linux on Docker desktop

# Set Docker environment
cd raketetech/docker
cp env.example .env
edit .env and set project path, environment etc

# MAC installation
PLATFORM=arm64v8 # amd64 for Linux | arm64v8 | for M2, M1
PLATFORM_TRAEFIK=arm64 # amd64 for Linux | arm64 | for M2, M1
PROJECT_PATH=/Volumes/projects/raketech

# Linux installation
PLATFORM=amd64 # amd64 for Linux | arm64v8 | for M2, M1
PLATFORM_TRAEFIK=amd64 # amd64 for Linux | arm64 | for M2, M1
PROJECT_PATH=/projects/raketech

# Generate ssl certificate
cd traefik
./certgen


# setup application 
cd ../docker
make install

# Application urls

http://be.localhost     - backend url
http://fe.localhost     - production url  
to get fe.localhost running

use make npm/fe run build 

http://nodefe.localhost - developer url
http://redis-commander.localhost



plus containers not used in this project
Mailbox to open verification emails
http://localhost:1080
Storybook
http://sb.localhost 



# Run tests

make test

# Docker structure

- traefik       -load balancer provide named host like be.localhost and handle ports
                  and easy to switch https/http in case of needs
- backend       - Nginx and php-fpm - Apache, PHP8.1, Laravel 9, Auth0
- frontend      - frontend nginx Vue 3, TailwindCss , Auth0
- nodefe        - frontend node Vue 3, TailwindCss, Auth0
- redis         - backend cache
- storybook     - design tool   
- mailbox       - local smtp, mailbox ideal for development 

# Most used make commands:

make up
make down
make npm/fe install
make mount/php
make artisan
make composer/update 
make build
make build/php
make uninstall (remove project docker images, volumes)

make help to see all of them


# Troubleshooting

Please read first above # Install application title.

If make install fail

These are the manual steps:

# Set project environment
cd ../../backend
cp env.example .env

cd ../../frontend
cp env.example .env

make build 
make up/install
make npm/fe install
make down/install

make up
make composer/install

# Uninstall

make down
make uninstall
