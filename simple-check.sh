#!/bin/bash          
read -p 'Enter your module folder path(avoid last Oblique): ' path
woo_template="$path/templates/woocommerce"

for singlepath in "$path/includes/modules/*/**.php"
do
    ./vendor/bin/phpcs --standard=ruleset.xml ${singlepath}
done



if [[ -d ${woo_template} ]]
then
	for template_path in "$woo_template/*/**.php"
	do 
		./vendor/bin/phpcs --standard=ruleset.xml ${template_path}
	done
fi 

echo 'all done'
