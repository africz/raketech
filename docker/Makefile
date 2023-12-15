LINUX_SHELL ?=/bin/bash
WORKFOLDER=/var/www/html
ENV_FILE = .env
SLEEP = 2
RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
.PHONY: list
list:
	$(call help)
.PHONY: help
help:
	$(call help)

artisan:
	$(call artisan)

build:
	$(call build_all)
build/backend:
	$(call build,backend)
build/frontend:
	$(call build,frontend)
build/admin:
	$(call build,admin)

build/php:
	$(call build,php)

build/mysql:
	$(call build,mysql)
build/mailbox:
	$(call build,mailbox)
build/nodefe:
	$(call build,nodefe)
build/nodead:
	$(call build,nodead)
build/storybook:
	$(call build,storybook)
build/traefik:
	$(call build_traefik)

composer:
	$(call composer)
composer/install:
	$(call composer_fp,install)
down:
	$(call down)
down/traefik:
	$(call downTraefik)
down/backend:
	$(call downProfile,backend)
down/frontend:
	$(call downProfile,frontend)
down/install:
	$(call downProfile,install)
down/admin:
	$(call downProfile,admin)
down/php:
	$(call downOne,php)
down/nodefe:
	$(call downOne,nodefe)
down/nodead:
	$(call downOne,nodead)

down/storybook:
	$(call downOne,storybook)

log/nginx:
	$(call container_log,nginx)
log/mysql:
	$(call container_log,mysql)

install:
	$(call install)
mount/backend:
	$(call mount_container,backend)
mount/frontend:
	$(call mount_container,frontend)
mount/admin:
	$(call mount_container,admin)
mount/php:
	$(call mount_container,php)
mount/mysql:
	$(call mount_container,mysql)
mount/nodefe:
	$(call mount_container,nodefe)
mount/nodead:
	$(call mount_container,nodead)
mount/storybook:
	$(call mount_container,storybook)

npm/fe:
	$(call npm,nodefe)	
npm/fe/install:
	$(call npm_fp ,nodefe,install)	

npm/ad:
	$(call npm,nodead)	
restart:
	$(call restart)	

test:
	$(call artisan_w_param,test)

up:
	$(call up)
up/network:
	$(call upNetwork)
up/traefik:
	$(call upTraefik)
up/backend:
	$(call upProfile,backend)
up/frontend:
	$(call upProfile,frontend)
up/install:
	$(call upProfile,install)
up/admin:
	$(call upProfile,admin)
up/php:
	$(call upOne,php)
up/nodefe:
	$(call upOne,nodefe)
up/nodead:
	$(call upOne,nodead)

up/storybook:
	$(call upOne,storybook)

uninstall:
	$(call uninstall)



define artisan
	$(call setup_env,$(ENV_FILE))
	docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-php php artisan $(RUN_ARGS)
endef

define npm
	$(call setup_env,$(ENV_FILE))
	docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-$(1) npm $(RUN_ARGS)
endef

define npm_fp
	$(call setup_env,$(ENV_FILE))
	docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-$(1) npm $(2)
endef



define artisan_w_param
	$(call setup_env,$(ENV_FILE))
	docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-php php artisan $(1)
endef


define build
	@set -a
	$(call setup_env,$(ENV_FILE))
	docker-compose --env-file $(ENV_FILE) build --build-arg platform=$(PLATFORM) $(1)
endef

define build_traefik
	@set -a
	$(call setup_env,$(ENV_FILE))
	cd traefik && docker-compose --env-file ../$(ENV_FILE) build --build-arg platform=$(PLATFORM_TRAEFIK) $(1)
endef

define build_all
	$(call build_traefik)
	$(call build,php)
	$(call build,redis)
	$(call build,redis-commander)
	$(call build,mailbox)
	$(call build,backend)
	$(call build,frontend)
	$(call build,nodefe)
	$(call build,storybook)

endef

define composer
	$(call setup_env,$(ENV_FILE))
	docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-php composer $(RUN_ARGS)
endef

define composer_fp
	$(call setup_env,$(ENV_FILE))
	docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-php composer $(1)
endef


define container_log
	$(call setup_env,$(ENV_FILE))
	docker logs -f ${PROJECT_NAME}-${CONFIG}-$(1)
endef

define down
	@set -a
	$(call source $(ENV_FILE))
	@echo === down app ===
	$(call downProfile,all)
	@echo === down traefik ===
	$(call downTraefik)
endef

define downOne
	$(call setup_env,$(ENV_FILE))
	@docker compose  --env-file $(ENV_FILE) stop $(1)
endef

define downTraefik
	@set -a
	$(call source ../$(ENV_FILE))
	@cd ./traefik && ./dn 
endef

define downPlatform
	@set -a
	$(call source $(ENV_FILE))
	@docker compose  --env-file $(ENV_FILE) down
endef

define downProfile
	@set -a
	$(call source $(ENV_FILE))
	@COMPOSE_PROFILES=$(1),common docker compose down
	@echo === list running containers ===
	@docker ps
endef

define install
	@set -a
	@$(call source $(ENV_FILE))
	@echo === setup backend/.env file ===
	cp ../backend/env.example ../backend/.env
	@echo === setup frontend/.env file ===
	cp ../frontend/env.example ../frontend/.env
	@echo === generate ssl cert ===
	cd ./traefik && ./certgen
	@echo === copy certs to nginx ===
	@sleep $(SLEEP)
    cp -R traefik/config/ssl ubuntu/nginx
	@echo === build images ===
	@sleep $(SLEEP)
	@make build
	@echo === start containers to install frontend ===
	@sleep $(SLEEP)
	@make up/install
	@echo === install frontend ===
	@sleep $(SLEEP)
	@make npm/fe/install
	@echo === down install ===
	@sleep $(SLEEP)
	@make down/install
	@echo === start all containers ===
	@sleep $(SLEEP)
	@make up
	@echo === install backend packages ===
	@sleep $(SLEEP)
	@make composer/install
	@echo === generate app key ===
	@make artisan key:generate
	@echo === Ready ===
	@echo http://fe.localhost              - frontend url
	@echo http://be.localhost              - backend url
	@echo http://sb.localhost              - storybook url
	@echo http://nodefe.localhost 	       - developer url
	@echo http://localhost:1080            - mailbox helper url
	@echo http://redis-commander.localhost - redis admin url
endef

define uninstall
	$(call down)
	@set -a
	$(call setup_env,$(ENV_FILE))
	@echo === delete project images ===
	@sleep $(SLEEP)
	cd ./scripts && ./delimages $(PROJECT_NAME)
	@echo === delete project volumes ===
	@sleep $(SLEEP)
	cd ./scripts && ./delvolumes $(PROJECT_NAME)
endef



define mount_container
	$(call setup_env,$(ENV_FILE))
	@docker exec -it -w ${WORKFOLDER} ${PROJECT_NAME}-${CONFIG}-$(1) $(LINUX_SHELL)
endef

define up
	@set -a
	$(call source $(ENV_FILE))
	@echo === launch network ===
	@./scripts/network
	@echo === launch traefik proxy ===
	$(call upTraefik)
	@echo === launch web ===
	$(call upProfile,all)
endef

define upProfile
	@set -a
	$(call source $(ENV_FILE))
	@COMPOSE_PROFILES=$(1),common docker compose up -d
	@echo === list stopped containers ===
	@docker ps -f "status=exited"
endef



define upOne
	$(call setup_env,$(ENV_FILE))
	@docker-compose  --env-file $(ENV_FILE)  start $(1)
endef

define upNetwork
	$(call source $(ENV_FILE))
endef

define upTraefik
	@set -a
	$(call source ../$(ENV_FILE))
	cd ./traefik && ./st 
endef

define upPlatform
	@set -a
	$(call source $(ENV_FILE))
	@docker compose  --env-file $(ENV_FILE)  up -d
endef




define setup_env
	$(shell test ! -f $(1) && echo $(ENV_FILE) file does not exist && exit)
    $(eval ENV_FILE := $(1))
    $(eval include $(1))
    $(eval export sed 's/=.*//' $(1))
endef

define restart
	$(call down)
	$(call up)
endef

define import_mysql
	@set -a
	$(call source $(ENV_FILE))
	@docker exec $(join mysql-,$(1)) /bin/sh -c "cat /sql/*.sql | mysql -u root -proot $(join ${PROJECT_NAME},$(shell echo $(1) | tr 'a-z' 'A-Z'))"
endef

define help
	@LC_ALL=C $(MAKE) -pRrq -f $(firstword $(MAKEFILE_LIST)) : 2>/dev/null | awk -v RS= -F: '/(^|\n)# Files(\n|$$)/,/(^|\n)# Finished Make data base/ {if ($$1 !~ "^[#.]") {print $$1}}' | sort | grep -E -v -e '^[^[:alnum:]]' -e '^$@$$'
endef
