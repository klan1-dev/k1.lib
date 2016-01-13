<?php

namespace k1lib\crudlexs;

interface crudlexs_base_interface {

    public function do_code();
}

class crudlexs_base {

    const USE_KEY_FIELDS = 1;
    const USE_ALL_FIELDS = 2;

    static protected $k1magic_value = null;

    /**
     *
     * @var \k1lib\crudlexs\class_db_table 
     */
    protected $db_table;

    static function get_k1magic_value() {
        return self::$k1magic_value;
    }

    static function set_k1magic_value($k1magic_value) {
        self::$k1magic_value = $k1magic_value;
    }

    public function __construct(\k1lib\crudlexs\class_db_table $db_table) {
        $this->db_table = $db_table;
    }

    /**
     * Always to create the object you must have a valid DB Table object already 
     * @param \k1lib\crudlexs\class_db_table $db_table DB Table object
     */
    public function __toString() {
        if ($this->get_state()) {
            return "1";
        } else {
            return "0";
        }
    }

    public function get_state() {
        if (empty($this->db_table)) {
            return FALSE;
        } else {
            if ($this->db_table->get_state()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}

class crudlexs_base_with_data extends crudlexs_base {

    /**
     *
     * @var Array 
     */
    protected $db_table_data = FALSE;

    /**
     *
     * @var Boolean 
     */
    protected $db_table_data_keys = FALSE;
    // FILTERS
    /**
     *
     * @var Array 
     */
    protected $db_table_data_filtered = FALSE;

    /**
     *
     * @var String
     */
    protected $auth_code = null;

    /**
     * Always to create the object you must have a valid DB Table object already 
     * @param \k1lib\crudlexs\class_db_table $db_table DB Table object
     */
    public function __construct(\k1lib\crudlexs\class_db_table $db_table, $row_keys_text = null) {
        if ($row_keys_text === FALSE) {
            parent::__construct($db_table);
        } else {
            if (isset($_GET['auth-code'])) {
                $auth_code = $_GET['auth-code'];
                $auth_expected = md5(\k1lib\MAGIC_VALUE . $row_keys_text);
                if ($auth_code === $auth_expected) {
                    parent::__construct($db_table);
                    $this->auth_code = $auth_code;
                    $row_keys_array = \k1lib\sql\table_url_text_to_keys($row_keys_text, $this->db_table->get_db_table_config());
                    $this->db_table->set_query_filter($row_keys_array, TRUE);
                }
            }
        }
    }

    function get_auth_code() {
        return $this->auth_code;
    }

    public function set_auth_code($row_keys_text) {
        $this->auth_code = md5(\k1lib\MAGIC_VALUE . $row_keys_text);
    }

    /**
     * 
     * @return Array Data with data[0] as table fields and data[1..n] for data rows. FALSE on no data.
     */
    public function load_db_table_data($return_all = TRUE, $do_fields = TRUE) {
        $this->db_table_data = $this->db_table->get_data($return_all, $do_fields);
        if ($this->db_table_data) {
            $this->db_table_data_filtered = $this->db_table_data;
            $this->db_table_data_keys = $this->db_table->get_data_keys($return_all, $do_fields);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function apply_label_filter() {
        if (empty($this->db_table_data) || !is_array($this->db_table_data)) {
            trigger_error("Can't work with an empty result", E_USER_WARNING);
            return FALSE;
        } else {
            $db_table_config = $this->db_table->get_db_table_config();
            if (isset($this->db_table_data[0]) && (count($this->db_table_data[0]) > 0)) {
                foreach ($this->db_table_data[0] as $index => $field_name) {
                    $this->db_table_data_filtered[0][$index] = $db_table_config[$field_name]['label'];
                }
            } else {
                return FALSE;
            }
            return TRUE;
        }
    }

    public function apply_html_tag_on_field_filter(\k1lib\html\html_tag $tag_object, $fields_to_change = crudlexs_base::USE_KEY_FIELDS, $append_auth_code = FALSE) {
        if (empty($this->db_table_data) || !is_array($this->db_table_data)) {
            trigger_error("Can't work without table data loaded first", E_USER_WARNING);
            return FALSE;
        } else {
            if ($fields_to_change == crudlexs_base::USE_KEY_FIELDS) {
                $fields_to_change = \k1lib\sql\get_db_table_keys_array($this->db_table->get_db_table_config());
            } elseif ($fields_to_change == crudlexs_base::USE_ALL_FIELDS) {
                $fields_to_change = $this->db_table_data[0];
            } else {
                if (!is_array($fields_to_change) && is_string($fields_to_change)) {
                    $fields_to_change = Array($fields_to_change);
                }
            }
            foreach ($fields_to_change as $field_to_change) {
                foreach ($this->db_table_data as $index => $row_data) {
                    if ($index === 0) {
                        continue;
                    }
                    if (isset($row_data[$field_to_change]) === false) {
//                        trigger_error("The field to change ($field_to_change) do no exist ", E_USER_WARNING);
                        continue;
                    } else {
//                    $key_array = \k1lib\sql\get_keys_array_from_row_data($row_data, $db_table_config);
                        $tag_object->set_value($row_data[$field_to_change]);
                        $tag_html = $tag_object->generate_tag();
                        if (!empty($this->db_table_data_keys)) {
                            $key_array_text = \k1lib\sql\table_keys_to_text($this->db_table_data_keys[$index], $this->db_table->get_db_table_config());
                            $auth_code = md5(\k1lib\MAGIC_VALUE . $key_array_text);
                            $tag_html = sprintf($tag_html, $key_array_text, $auth_code);
                        }
//                        d($link_with_key);
                        $this->db_table_data_filtered[$index][$field_to_change] = $tag_html;
                    }
                }
            }

            return TRUE;
        }
    }

    public function apply_link_on_field_filter($link_to_apply, $fields_to_change = null) {
        $a_tag = new \k1lib\html\a_tag($link_to_apply, "");
        $a_tag->set_attrib("class", "k1-link-filter", TRUE);
        return $this->apply_html_tag_on_field_filter($a_tag, $fields_to_change);
    }

}