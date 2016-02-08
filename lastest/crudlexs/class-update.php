<?php

namespace k1lib\crudlexs;

use \k1lib\urlrewrite\url_manager as url_manager;

class updating extends \k1lib\crudlexs\creating {

    public function __construct(\k1lib\crudlexs\class_db_table $db_table, $row_keys_text) {
        if (!empty($row_keys_text)) {
            parent::__construct($db_table, $row_keys_text);
        } else {
            \k1lib\common\show_message("The keys can't be empty", "Error", "alert");
        }
        creating_strings::$button_submit = updating_strings::$button_submit;
        creating_strings::$select_choose_option = updating_strings::$select_choose_option;
    }

    public function load_db_table_data($blank_data = FALSE) {
        $return_data = parent::load_db_table_data($blank_data);

        $url_action = url_manager::set_url_rewrite_var(url_manager::get_url_level_count(), "url_action", FALSE);
        $url_action_on_encoded_field = url_manager::set_url_rewrite_var(url_manager::get_url_level_count(), "url_action_on_encoded_field", FALSE);
        $url_action_on_field = $this->decrypt_field_name($url_action_on_encoded_field);

        if ($url_action == "unlink-uploaded-file") {
            \k1lib\forms\file_uploads::unlink_uploaded_file($this->db_table_data[1][$url_action_on_field]);
            $this->db_table_data[1][$url_action_on_field] = NULL;
            $this->db_table->update_data($this->db_table_data[1], $this->db_table_data_keys[1]);
            \k1lib\html\html_header_go(\k1lib\urlrewrite\get_back_url());
        }

        return $return_data;
    }

    public function do_update($url_to_go = "../../") {
        if ($this->db_table->update_data($this->post_incoming_array, $this->db_table_data_keys[1])) {
            $this->set_back_url("javascript:history.back()");
            $this->div_container->set_attrib("class", "k1-crudlexs-update");
            /**
             * Merge the ROW KEYS with all the possible keys on the POST array
             */
            $merged_key_array = array_merge(
                    $this->db_table_data_keys[1]
                    , \k1lib\sql\get_keys_array_from_row_data(
                            $this->post_incoming_array
                            , $this->db_table->get_db_table_config())
            );
            $row_key_text = \k1lib\sql\table_keys_to_text($merged_key_array, $this->db_table->get_db_table_config());
            if (!empty($url_to_go)) {
                $this->set_auth_code($row_key_text);
                $url_to_go = str_replace("%row_keys%", $row_key_text, $url_to_go);
                $url_to_go = str_replace("%auth_code%", $this->get_auth_code(), $url_to_go);
                \k1lib\html\html_header_go($url_to_go);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

class updating_strings {

    static $button_submit = "Update";
    static $select_choose_option = "Select an option...";

}
