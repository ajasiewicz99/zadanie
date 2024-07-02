run:
	@docker compose -f .docker/docker-compose.yml up -d
stop:
	@docker compose -f .docker/docker-compose.yml down
php:
	@docker-compose -f .docker/docker-compose.yml exec php bash
