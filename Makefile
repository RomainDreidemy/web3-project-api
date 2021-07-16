SYMFONY=php bin/console
COMPOSER=composer

init_local:
	$(COMPOSER) install

	$(SYMFONY) doctrine:database:create --if-not-exists --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
	$(SYMFONY) doctrine:fixtures:load --no-interaction

	$(SYMFONY) lexik:jwt:generate-keypair --overwrite --no-interaction

	$(SYMFONY) cache:clear
	$(SYMFONY) cache:warmup