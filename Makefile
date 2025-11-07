all: log
log:
	tail -f -n 1000 /var/log/apache2/prestashop_error.log