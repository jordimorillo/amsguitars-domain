up:
	@docker-compose up -d

down:
	@docker-compose down

destroy:
	@docker system prune -a --volumes

mysql-bash:
	@docker exec -it mysql bash
