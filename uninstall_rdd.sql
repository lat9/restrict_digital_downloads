#
# Run this SQL script using your Zen Cart Tools->Install SQL Patches AFTER you have
# deleted the PHP files for the plugin from your admin and store-side directories.
#
DROP TABLE ip2country;
DELETE FROM configuration WHERE configuration_key LIKE 'MODULE_IP2COUNTRY_%';
DELETE FROM admin_pages WHERE page_key='toolsUpdateIP2Country';