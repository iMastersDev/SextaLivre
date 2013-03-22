<?php
/*
Plugin name: Cronometro Sexta Livre
Description: Cronometro para gerenciamento de horas trabalhadas
Author: João^2
Author URI: http://imasters.com.br
Version: 1.0
*/

class Cronometro_Sexta_Livre
{
    private $capability = 'sl_manage_timer';

    public function __construct()
    {
        global $wpdb;

        $wpdb->timer_table = $wpdb->prefix . 'timer';

        add_action('activate_cronometro-sexta-livre/cronometro-sexta-livre.php', array($this, 'install'));
    }

    public function install()
    {
        global $wpdb;

        $role = get_role('administrator');

        if(!$role->has_cap($capability)) {
            $role->add_cap($capability);
        }

        include_once ABSPATH . '/wp-admin/includes/upgrade.php';

        if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->timer_table . '"') !== $wpdb->scb_inscriptions) {
            $sql = 'CREATE TABLE '. $wpdb->timer_table . '(
                `timer_id`          MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                `timer_project`     VARCHAR(150)          NOT NULL,
                `timer_type`        TINYINT(1)   UNSIGNED NOT NULL,
                `timer_timestamp`   TIMESTAMP             NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`timer_id`),
                INDEX `project`(`timer_project` ASC, `timer_type` ASC)
            );';

            dbDelta($sql);
        }
    }
}
