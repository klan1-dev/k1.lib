<?php

/**
 * HTML Classes for general propouses use
 */

namespace k1lib\html {

    class a_tag extends html_tag {

        function __construct($href, $label, $target = "", $alt = "", $class = "", $id = "") {
            parent::__construct("a", FALSE);
            $this->set_attrib("href", $href);
            $this->set_value($label);
            $this->set_attrib("target", $target);
            $this->set_attrib("alt", $alt);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class img_tag extends html_tag {

        function __construct($src = "", $alt = "", $class = "", $id = "") {
            parent::__construct("img", FALSE);
            $this->set_attrib("src", $src);
            $this->set_attrib("alt", $alt);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        function set_value($value, $append = FALSE) {
            $this->set_attrib("alt", $value, $append);
        }

    }

    class div_tag extends html_tag {

        /**
         * Create a DIV html tag with VALUE as data. Use $div->set_value($data)
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("div", FALSE);
//        $this->data_array &= $data_array;
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class ul_tag extends html_tag {

        /**
         * Create a UL html tag.
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("ul", FALSE);
//        $this->data_array &= $data_array;
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        function set_value($value, $append = false) {
//            parent::set_value($value, $append);
        }

        /**
         * 
         * @param string $class
         * @param string $id
         * @return \k1lib\html\li_tag
         */
        function &append_li($class = "", $id = "") {
            $new = new li_tag($value, $class, $id);
            $this->append_child($new);
            return $new;
        }

    }

    class ol_tag extends html_tag {

        /**
         * Create a UL html tag.
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("ol", FALSE);
//        $this->data_array &= $data_array;
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        function set_value($value, $append = false) {
//            parent::set_value($value, $append);
        }

        /**
         * 
         * @param string $class
         * @param string $id
         * @return \k1lib\html\li_tag
         */
        function &append_li($value = "", $class = "", $id = "") {
            $new = new li_tag($value, $class, $id);
            $this->set_value($value);
            $this->append_child($new);
            return $new;
        }

    }

    class li_tag extends html_tag {

        /**
         * Create a LI html tag with VALUE as data. Use $div->set_value($data)
         * @param String $class
         * @param String $id
         */
        function __construct($value = "", $class = "", $id = "") {
            parent::__construct("li", FALSE);
//        $this->data_array &= $data_array;
            $this->set_value($value);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        /**
         * 
         * @param string $class
         * @param string $id
         * @return \k1lib\html\ul_tag
         */
        function &append_ul($class = "", $id = "") {
            $new = new ul_tag($class, $id);
            $this->append_child($new);
            return $new;
        }

        /**
         * 
         * @param string $class
         * @param string $id
         * @return \k1lib\html\div_tag
         */
        function &append_ol($class = "", $id = "") {
            $new = new ol_tag($class, $id);
            $this->append_child($new);
            return $new;
        }

    }

    class script_tag extends html_tag {

        /**
         * Create a SCRIPT html tag with VALUE as data. Use $script->set_value($data)
         * @param String $class
         * @param String $id
         */
        function __construct($code = "") {
            parent::__construct("script", FALSE);
            $this->set_value($code);
//        $this->data_array &= $data_array;
        }

    }

    class small_tag extends html_tag {

        /**
         * Create a SMALL html tag with VALUE as data. Use $small->set_value($data)
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("small", FALSE);
//        $this->data_array &= $data_array;
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class span_tag extends html_tag {

        /**
         * Create a SPAN html tag with VALUE as data. Use $span->set_value($data)
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("span", FALSE);
//        $this->data_array &= $data_array;
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class table_tag extends html_tag {

//    private $data_array = array();
        /**
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("table", FALSE);
//        $this->data_array &= $data_array;
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        /**
         * Chains a new <THEAD> HTML TAG
         * @param String $class
         * @param String $id
         * @return \k1lib\html\thead_tag
         */
        function &append_thead($class = "", $id = "") {
            $child_object = new thead_tag($class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

        /**
         * Chains a new <TBODY> HTML TAG
         * @param String $class
         * @param String $id
         * @return \k1lib\html\tbody_tag
         */
        function &append_tbody($class = "", $id = "") {
            $child_object = new tbody_tag($class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

    }

    class thead_tag extends html_tag {

        /**
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("thead", FALSE);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        /**
         * Chains a new <TR> HTML TAG
         * @param String $class
         * @param String $id
         * @return \k1lib\html\tr_tag
         */
        function append_tr($class = "", $id = "") {
            $child_object = new tr_tag($class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

    }

    class tbody_tag extends html_tag {

        /**
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("tbody", FALSE);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        /**
         * Chains a new <TR> HTML TAG
         * @param String $class
         * @param String $id
         * @return \k1lib\html\tr_tag
         */
        function append_tr($class = "", $id = "") {
            $child_object = new tr_tag($class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

    }

    class tr_tag extends html_tag {

        /**
         * @param String $class
         * @param String $id
         */
        function __construct($class = "", $id = "") {
            parent::__construct("tr", FALSE);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        /**
         * Chains a new <TH> HTML TAG
         * @param String $value <TAG>$value</TAG>
         * @param String $class
         * @param String $id
         * @return \k1lib\html\th_tag
         */
        function append_th($value, $class = "", $id = "") {
            $child_object = new th_tag($value, $class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

        /**
         * Chains a new <TD> HTML TAG
         * @param String $value <TAG>$value</TAG>
         * @param String $class
         * @param String $id
         * @return \k1lib\html\td_tag
         */
        function append_td($value, $class = "", $id = "") {
            $child_object = new td_tag($value, $class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

    }

    class th_tag extends html_tag {

        /**
         * @param String $value <TAG>$value</TAG>
         * @param String $class
         * @param String $id
         */
        function __construct($value, $class = "", $id = "") {
            parent::__construct("th", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class td_tag extends html_tag {

        /**
         * @param String $value <TAG>$value</TAG>
         * @param String $class
         * @param String $id
         */
        function __construct($value, $class = "", $id = "") {
            parent::__construct("td", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class input_tag extends html_tag {

        /**
         * @param String $type Should be HTML standars: text, button.... 
         * @param String $name
         * @param String $value <TAG value='$value' />
         * @param String $class
         * @param String $id
         */
        function __construct($type, $name, $value, $class = "", $id = "") {
            parent::__construct("input", TRUE);
            $this->set_attrib("type", $type);
            $this->set_attrib("name", $name);
            $this->set_value($value);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class textarea_tag extends html_tag {

        /**
         * 
         * @param string $name
         * @param string $class
         * @param string $id
         */
        function __construct($name, $class = "", $id = "") {
            parent::__construct("textarea", FALSE);
            $this->set_attrib("name", $name);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
            $this->set_attrib("rows", 10);
        }

    }

    class label_tag extends html_tag {

        /**
         * @param String $label <TAG>$value</TAG>
         * @param String $for
         * @param String $class
         * @param String $id
         */
        function __construct($label, $for, $class = "", $id = "") {
            parent::__construct("label", FALSE);
            $this->set_value($label);
            $this->set_attrib("for", $for);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    class select_tag extends html_tag {

        /**
         * @param String $name
         * @param String $class
         * @param String $id
         */
        function __construct($name, $class = "", $id = "") {
            parent::__construct("select", FALSE);
            $this->set_attrib("name", $name);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

        /**
         * Chains a new <OPTION> HTML TAG
         * @param String $value
         * @param String $label
         * @param Boolean $selected
         * @param String $class
         * @param String $id
         * @return \k1lib\html\option_tag
         */
        function append_option($value, $label, $selected = FALSE, $class = "", $id = "") {
            $child_object = new option_tag($value, $label, $selected, $class, $id);
            $this->append_child($child_object);
            return $child_object;
        }

    }

    class option_tag extends html_tag {

        /**
         * @param String $value <TAG value='$value' />
         * @param String $label <TAG>$label</TAG>
         * @param Boolean $selected
         * @param String $class
         * @param String $id
         */
        function __construct($value, $label, $selected = FALSE, $class = "", $id = "") {
            parent::__construct("option", FALSE);
            $this->set_value($label);
            $this->set_attrib("value", $value);
            $this->set_attrib("selected", $selected);
            $this->set_attrib("class", $class, TRUE);
            $this->set_attrib("id", $id);
        }

    }

    /**
     * FORM
     */
    class form_tag extends html_tag {

        function __construct($id = "k1-form") {
            parent::__construct("form", FALSE);
            $this->set_attrib("id", $id);
            $this->set_attrib("name", "k1-form");
            $this->set_attrib("method", "post");
            $this->set_attrib("autocomplete", "yes");
            $this->set_attrib("enctype", "multipart/form-data");
            $this->set_attrib("novalidate", FALSE);
            $this->set_attrib("target", "_self");
        }

        /**
         * 
         * @param string $label
         * @param boolean $just_return
         * @return \k1lib\html\input_tag
         */
        function append_submit_button($label = "Enviar", $just_return = FALSE) {
            $button = new input_tag("submit", "submit-it", $label, "button success");
            if (!$just_return) {
                $this->append_child($button);
            }
            return $button;
        }

    }

    /**
     * P
     */
    class p_tag extends html_tag {

        function __construct($value = "", $class = "", $id = "") {
            parent::__construct("p", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class);
            $this->set_attrib("id", $id);
        }

    }

    /**
     * h1
     */
    class h1_tag extends html_tag {

        function __construct($value = "", $class = "") {
            parent::__construct("h1", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class);
        }

    }

    /**
     * h2
     */
    class h2_tag extends html_tag {

        function __construct($value = "", $class = "") {
            parent::__construct("h2", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class);
        }

    }

    /**
     * h3
     */
    class h3_tag extends html_tag {

        function __construct($value = "", $class = "") {
            parent::__construct("h3", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class);
        }

    }

    /**
     * h4
     */
    class h4_tag extends html_tag {

        function __construct($value = "", $class = "") {
            parent::__construct("h4", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class);
        }

    }

    /**
     * h5
     */
    class h5_tag extends html_tag {

        function __construct($value = "", $class = "") {
            parent::__construct("h5", FALSE);
            $this->set_value($value);
            $this->set_attrib("class", $class);
        }

    }

    /**
     * P
     */
    class fieldset_tag extends html_tag {

        function __construct($legend) {
            parent::__construct("fieldset", FALSE);
            $this->set_attrib("class", "fieldset");
            $legend = new legend_tag($legend);
            $this->append_child($legend);
        }

    }

    class legend_tag extends html_tag {

        function __construct($value) {
            parent::__construct("legend", FALSE);
            $this->set_value($value);
        }

    }

}