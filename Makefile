TITLE = [collection]

##############################################################################################
################################### T E S T   S U I T E S ####################################
##############################################################################################

unit-tests:
	@/bin/echo "${TITLE} running unit tests suite..." \
	&& ./vendor/bin/phpunit -c tests/unit/phpunit.xml --coverage-html tests/unit/coverage \
	&& /bin/echo "${TITLE} unit tests completed"

##############################################################################################
####################################### C O M P O S E R ######################################
##############################################################################################

autoload:
	@/bin/echo -e "${TITLE} generating autoloader..." \
	&& composer dump-autoload --optimize

clean-composer-lock:
	@rm -rf composer.lock \
	&& /bin/echo -e "${TITLE} deleted composer.lock"

install: get-composer
	@/bin/echo -e "${TITLE} installing dependencies and dev dependencies..." \
	&& COMPOSER_ALLOW_SUPERUSER=1 composer install --optimize-autoloader --no-plugins --no-scripts \
	&& /bin/echo -e "${TITLE} dependencies installed"

update: clean-composer-lock
	@ /bin/echo -e "${TITLE} update dependencies..." \
	&& COMPOSER_ALLOW_SUPERUSER=1 composer update --optimize-autoloader --no-plugins --no-scripts $(p)\
	&& /bin/echo -e "${TITLE} dependencies updated"
