#!/bin/bash          
read -p 'Enter your module folder path(avoid last Oblique): ' path


for singlepath in "$path/includes/modules/*/**.php"
do
    ./vendor/bin/phpcs --standard=ruleset.xml ${singlepath}
done

echo 'all done'