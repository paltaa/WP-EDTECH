<?php
if (!wp_next_scheduled('schedule_hourly_id_cron')) {
	wp_schedule_event(time(), 'hourly', 'schedule_hourly_id_cron');
}

if (!wp_next_scheduled('schedule_twicedaily_id_cron')) {
	wp_schedule_event(time(), 'twicedaily', 'schedule_twicedaily_id_cron');
}

function schedule_hourly_id_cron() {
	$raised = ID_Project::set_raised_meta();
	$percent = ID_Project::set_percent_meta();
	$days = ID_Project::set_days_meta();
	$closed = ID_Project::set_closed_meta();
}

add_action('schedule_hourly_id_cron', 'schedule_hourly_id_cron');

function schedule_twicedaily_id_cron() {
	$is_pro = false;
	$is_basic = false;
	$key = get_option('id_license_key');
	$validate = id_validate_license($key);
	if (isset($validate['response'])) {
		if ($validate['response']) {
			if (isset($validate['download'])) {
				if ($validate['download'] == '30') {
					$is_pro = 1;
				}
				else if ($validate['download'] == '1') {
					$is_basic = 1;
				}
			}
		}
	}
	update_option('is_id_pro', $is_pro);
	update_option('is_id_basic', $is_basic);
	if ($is_pro || $is_basic) {
		update_option('was_id_licensed', 1);
	}
	if ($is_pro) {
		update_option('was_id_pro', 1);
	}
}

add_action('schedule_twicedaily_id_cron', 'schedule_twicedaily_id_cron');
?>