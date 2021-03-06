<?php
function is_idcf_key_valid($data) {
	$valid = 0;
	if (isset($data['response'])) {
		if ($data['response']) {
			if (isset($data['download'])) {
				if ($data['download'] == '30') {
					$valid = 1;
				}
				else if ($validate['download'] == '1') {
					$valid = 1;
				}
			}
		}
	}
	return $valid;
}

function idcf_license_type($data) {
	switch ($data['download']) {
		case '30':
			return 3;
			break;
		case '1':
			return 1;
			break;
		default:
			return 0;
			break;
	}
}

function idcf_mode() {
	$mode = idf_platform();
	if ($mode == 'idc') {
		if (function_exists('is_idc_free') && is_idc_free()) {
			$mode = 'idc_free';
		}
	}
	return $mode;
}

add_action('idcf_license_update', 'idcf_license_update');

function idcf_license_update($license_key) {
	$is_pro = 0;
	$is_basic = 0;
	update_option('id_license_key', $license_key);
	$validate = id_validate_license($license_key);
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
	set_transient('is_id_pro', $is_pro);
	set_transient('is_id_basic', $is_basic);
	if ($is_pro || $is_basic) {
		update_option('was_id_licensed', 1);
	}
	if ($is_pro) {
		update_option('was_id_pro', 1);
	}
}

function idf_schedule_twicedaily_idcf_cron() {
	$key = get_option('id_license_key');
	idcf_license_update($key);
}

add_action('schedule_twicedaily_idf_cron', 'idf_schedule_twicedaily_idcf_cron');
?>