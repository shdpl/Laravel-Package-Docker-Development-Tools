up:
	- docker-compose up -d
	- [[ -e ./host/.env ]] || cp ./host/.env.default ./host/.env
bash: 
	- docker-compose exec escola_lms_app bash
