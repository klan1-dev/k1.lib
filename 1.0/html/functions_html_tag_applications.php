<?php

/**
 * HTML Related funcions that uses the HTML Classes
 */

namespace k1lib\html;

use k1lib\html as html_classes;

/**
 * Loads files and get contents from templates directory from k1.lib no from the app template directory.
 * Returns FALSE on load error.
 * @param String $function_name
 * @return String
 */
function load_html_template($function_name) {
    $function_name_fixed = \str_replace("\\", "/", $function_name);
    $file_to_load = \k1lib\HTML_TEMPLATES_PATH . "/" . \basename($function_name_fixed) . ".html";
    if (\file_exists($file_to_load)) {
        $template_content = \file_get_contents($file_to_load);
        return $template_content;
    }
    \trigger_error("No se ha podido cargar: {$file_to_load}", E_USER_WARNING);
    return FALSE;
}

/**
 * Using a HTML Template makes the couple of label-inpunt
 * @param String $field_name
 * @param String $value
 * @param String $label
 * @param Boolean $required
 * @param String $error_msg
 * @return String
 */
function label_input_text_combo($field_name, $value, $label, $required = FALSE, $error_msg = "") {

//    function \k1lib\html\input_label_combo(&$field_name, &$value, &$table_config_array, &$error_msg = "") {
    if ($required) {
        $required_class = "required";
    } else {
        $required_class = "";
    }
    $label_object = new html_classes\label_tag($label, $field_name, "right inline");
    $input_object = new html_classes\input_tag("text", $field_name, $value, $required_class);
    $input_object->set_attrib("required", (!empty($required_class)) ? TRUE : FALSE);

    if (!empty($error_msg)) {
        $input_object->set_attrib("class", "error", TRUE);
        $html_template = load_html_template("label_input_combo-error");
        $html_code = sprintf($html_template, $label_object->generate_tag(), $input_object->generate_tag(), $error_msg);
    } else {
        $html_template = load_html_template("label_input_combo");
        $html_code = sprintf($html_template, $label_object->generate_tag(), $input_object->generate_tag());
    }
    return $html_code;
}

/**
 * Generate a <SELECT></SELECT> HTML tag with options from an Array() 
 * @param String $name
 * @param Array $data_array
 * @param type $default_value
 * @param Boolean $allow_empty
 * @param String $class
 * @param String $id
 * @return String
 */
function select_list_from_array($name, $data_array, $default_value = "", $allow_empty = FALSE, $class = "", $id = "") {
    $select_object = new html_classes\select_tag($name);
    $select_object->set_attrib("class", $class, TRUE);
    $select_object->set_attrib("id", $id);

    if ($allow_empty) {
        $select_object->append_option("", "Seleccione una opcion");
    }

    foreach ($data_array as $value => $label) {
        $select_object->append_option($value, $label, (($value === $default_value) ? TRUE : FALSE));
    }
    return $select_object->generate_tag();
}

/**
 * Generate a <TABLE></TABLE> HTML tag with data from an Array() 
 * @param Array $data_array
 * @param Boolean $has_header
 * @param String $class
 * @param String $id
 * @return String
 */
function table_from_array(&$data_array, $has_header = TRUE, $class = "", $id = "") {
    if ((count($data_array) == 0) || (count(current($data_array)) == 0)) {
        trigger_error("Array to build HTML table is empty", E_USER_NOTICE);
        return FALSE;
    }
    $table_object = new html_classes\table_tag($class, $id);

    foreach ($data_array as $row_actual_index => $row_data) {
        if ($has_header && ($row_actual_index === 0)) {
            $thead = $table_object->append_thead();
            $tr = $thead->append_tr();
        } else {
            if (!isset($tbody)) {
                $tbody = $table_object->append_tbody();
            }
            $tr = $tbody->append_tr();
        }
        foreach ($row_data as $col_index => $col_value) {
            if ($has_header && ($row_actual_index === 0)) {
                $tr->append_th($col_value);
            } else {
                $tr->append_td($col_value);
            }
        }
    }
//        \var_dump($table_object);
    return $table_object->generate_tag();
}

function get_link_button($linkTo, $label, $mini = TRUE, $inline = TRUE) {
    if ($linkTo == NULL) {
        return NULL;
    } elseif (!(is_string($linkTo) && is_string($label))) {
        die(__FUNCTION__ . " The parameters are not string");
    }

    $possible_strings = array(
        "export" => array(
            "exportar",
            "export",
        ),
        "back" => array(
            "back",
            "volver",
            "atras",
            "retroceder",
            "regresar",
        ),
        "go" => array(
            "ir",
            "go",
        ),
        "ok" => array(
            "aceptar",
            "si",
            "yes",
            "accept",
        ),
        "cancel" => array(
            "cancelar",
            "cancel",
            "no",
            "not",
        ),
        "view" => array(
            "ver",
            "mostrar",
            "view",
            "show",
        ),
        "new" => array(
            "agregar",
            "nuev",
            "new",
            "add",
            "añadir",
            "crear",
            "generar",
        ),
        "edit" => array(
            "edit",
            "cambiar",
            "change",
        ),
        "delete" => array(
            "delete",
            "borrar",
            "eliminar",
            "suprimir",
            "quitar",
            "cancelar",
        ),
    );

    $label_low = strtolower($label);
    $possible_action = "";
    foreach ($possible_strings as $possible_action_loop => $words) {
        foreach ($words as $word) {
            if (strstr($label_low, $word) !== FALSE) {
                $possible_action = $possible_action_loop;
                break 2;
            }
        }
    }

    $js_confirm_dialog = FALSE;
    switch ($possible_action) {
        case "export":
            $button_icon = "fi-download";
            $theme = "secondary";
            break;
        case "back":
            $button_icon = "fi-arrow-left";
            $theme = "";
            break;
        case "go":
            $button_icon = "fi-check";
            $theme = "success";
            break;
        case "cancel":
            $button_icon = "fi-x";
            $theme = "alert";
            break;
        case "ok":
            $button_icon = "fi-check";
            $theme = "success";
            break;
        case "view":
            $button_icon = "fi-clipboard-notes";
            $theme = "";
            break;
        case "new":
            $button_icon = "fi-plus";
            $theme = "";
            break;
        case "edit":
            $button_icon = "fi-clipboard-pencil";
            $theme = "";
            break;
        case "delete":
            $button_icon = "fi-page-delete";
            $theme = "alert";
            $js_confirm_dialog = TRUE;
            break;
        default:
            $button_icon = "fi-widget";
            $theme = "secondary";
            break;
    }

    if ((strstr($linkTo, "http") === FALSE) && (strstr($linkTo, "javascript:") === FALSE)) {
        $linkTo = \k1lib\urlrewrite\url_manager::get_app_link($linkTo);
    }
    $button_object = new \k1lib\html\a_tag($linkTo, " " . $label, "_self", "App link", "button");
    $button_object->set_attrib("class", "$button_icon", TRUE);
    $button_object->set_attrib("class", "$theme", TRUE);
    if ($js_confirm_dialog) {
        $button_object->set_attrib("onclick", "return confirm('Esta seguro que desea hacer esto ?\\n\\nEsta accion no se podra deshacer.')");
    }
    if ($inline) {
        $button_object->set_attrib("class", "inline", TRUE);
    }
    if ($mini) {
        $button_object->set_attrib("class", "tiny", TRUE);
    }

    return $button_object->generate_tag();
}