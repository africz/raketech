# Get the source code
``git clone git@github.com:africz/raketech.git``

Make sure docker desktop is running
I did test with Mac and Linux on Docker desktop

# Set Docker environment
```cd raketetech/docker```

```cp env.example .env```
edit .env and set project path, environment etc

# MAC installation
PLATFORM=arm64v8 # amd64 for Linux | arm64v8 | for M2, M1
PLATFORM_TRAEFIK=arm64 # amd64 for Linux | arm64 | for M2, M1
PROJECT_PATH=/Volumes/projects/raketech

# Linux installation
PLATFORM=amd64 # amd64 for Linux | arm64v8 | for M2, M1
PLATFORM_TRAEFIK=amd64 # amd64 for Linux | arm64 | for M2, M1
PROJECT_PATH=/projects/raketech


# Install application 
```cd ../docker```

```make setup```

# Application urls

http://be.localhost     - backend url
http://fe.localhost     - production url  
to get fe.localhost running

use ```make npm/fe run build```

http://nodefe.localhost - developer url
http://redis-commander.localhost



plus containers not used in this project
Mailbox to open verification emails
http://localhost:1080
Storybook
http://sb.localhost 


# Run on https connection

Default setting is http to avoid any certificate issues. 
Install process generated the necessary ssl certs.
If you wish to try it on https you need to set protocol in all 
environments.

- in docker/.env 
```DOCKER_STACK_SSL=true``
- in backend/.env
```APP_URL=https://be.localhost```
- in frontend/.env
```VITE_API_URL=https://be.localhost/api```


# Run tests

```make test```

# Docker structure

- traefik       -load balancer provide named host like be.localhost and handle ports
                  and easy to switch https/http in case of needs
- backend       - Nginx and php-fpm - Apache, PHP8.1, Laravel 9, Auth0
- frontend      - frontend nginx Vue 3, TailwindCss , Auth0
- nodefe        - frontend node Vue 3, TailwindCss, Auth0
- redis         - backend cache
- storybook     - design tool   
- mailbox       - local smtp, mailbox ideal for development 

This configuration is capable to handle many environments
for example if you want to switch from Ubuntu to Almalinux 
You can clone Ubuntu Config folder and make mods and run for working 
Ubuntu and get experience with Alma, volumes are shared between configs.
This flexible configuration is very useful in upgrading process to make it safely done.

# Most used make commands:

```make up```

```make down```

```make restart```

```make npm/fe install```

```make mount/php```

```make artisan```

```make composer/update```

```make build```

```make build/php```

```make uninstall``` (remove project docker images, volumes)

if you need to execute commands with space put the expression to ""
like make composer "require package name"

```make help``` to see all of them

if parameters has space use ""

make artisan "make:test UserTest --unit"



# Troubleshooting

!!! Please read first and execute # Install application section at top of the page !!!

If make setup fail, simple try again with make setup
sometimes compiling or installing get stuck
if reinstall not helps you need to execute install steps
manually and fix the step if needs.
I did test installer several times on Mac and Linux to make it
trouble free.

These are the manual steps:

# Set project environment
```cd ../../backend```

```cp env.example .env```
```cp auth0.app.json.example .auth0.app.json```
```cp auth0.api.json.example .auth0.api.json```

```cd ../../frontend```

```cp env.example .env```

# Generate ssl certificate
```cd traefik```

```./certgen```


```make build```

you can build by units 
like make build/backend

```make up/install```

```make npm/fe install```

```make composer/install```

```make down/install```

```make up```

# Uninstall

```make down```

```make uninstall```

