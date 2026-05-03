.PHONY: help up down build install bash logs

DOCKER_COMPOSE = docker compose

help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Start containers in the background
	$(DOCKER_COMPOSE) up -d

down: ## Stop containers
	$(DOCKER_COMPOSE) down

build: ## Build docker images
	$(DOCKER_COMPOSE) build

install: build up ## Install dependencies and setup the project
	$(DOCKER_COMPOSE) exec php composer install
	$(DOCKER_COMPOSE) exec php npm install
	$(DOCKER_COMPOSE) exec php npm run build
	$(DOCKER_COMPOSE) exec php bin/console doctrine:migrations:migrate --no-interaction

bash: ## Open bash inside the PHP container
	$(DOCKER_COMPOSE) exec php bash

logs: ## Tail docker logs
	$(DOCKER_COMPOSE) logs -f
r