<?php

namespace k1lib\crudlexs;

/**
 * 
 */
class listing extends crudlexs_base_with_data implements crudlexs_base_interface {

    public function do_code() {
        if ($this->db_table_data) {
            $html_table = \k1lib\html\table_from_array($this->db_table_data_filtered);
            return $html_table;
        } else {
            return FALSE;
        }
    }

}
