<?php

namespace k1lib\sql\classes;

trait common_code {

    /**
     * Enable state
     * @var Boolean 
     */
    static private $enabled = false;

    /**
     *
     * @var Int 
     */
    static private $data_count = 0;

    /**
     * Stores the SQL data
     * @var Array
     */
    static private $data = array();

    /**
     * Enable the engenie
     */
    static public function enable() {
        self::$enabled = true;
    }

    /**
     * Query the enabled state
     * @return Boolean
     */
    static public function is_enabled() {
        return self::$enabled;
    }

    static public function get_data() {
        return self::$data;
    }

}

class profiler {

    use common_code;

    /**
     * Begin a SQL Profile with a SQL query code 
     * @param String $sql_query
     * @return Int Profile ID
     */
    static public function add($sql_query) {
        $sql_md5 = md5($sql_query);
        self::$data_count++;
        self::$data[self::$data_count]['md5'] = $sql_md5;
        self::$data[self::$data_count]['sql'] = $sql_query;
        return self::$data_count;
    }

    /**
     * Begin the time count
     * @param Int $profile_id Profile ID
     */
    static public function start_time_count($profile_id) {
        self::$data[$profile_id]['start_time'] = microtime(true);
    }

    /**
     * Stop the time count
     * @param Int $profile_id Profile ID
     */
    static public function stop_time_count($profile_id) {
        self::$data[$profile_id]['stop_time'] = microtime(true);
        self::$data[$profile_id]['total_time'] = self::$data[self::$data_count]['stop_time'] - self::$data[self::$data_count]['start_time'];
    }

    /**
     * Keep record of cache use of the current query
     * @param Int $profile_id Profile ID
     * @param Boolean $is_cached 
     */
    static public function set_is_cached($profile_id, $is_cached) {
        if (self::is_enabled()) {
            self::$data[$profile_id]['cache'] = $is_cached;
        }
    }

    /**
     * Filter the data by MD5
     * @param String $md5
     * @return Array
     */
    static public function get_by_md5($md5) {
        $data_filtered = array();
        foreach (self::$data as $id => $profile_data) {
            if ($profile_data['md5'] == $md5) {
                $data_filtered[] = $profile_data;
            }
        }
        return $data_filtered;
    }

}

class local_cache {

    use common_code;

    /**
     * Put a SQL_RESULT on the LOCAL CACHE
     * @param type $sql_query
     * @param type $sql_result
     */
    static public function add($sql_query, $sql_result) {
        $sql_md5 = md5($sql_query);
        self::$data_count++;
        self::$data[$sql_md5] = $sql_result;
    }

    /**
     * Return if the SQL QUERY is on cache or not
     * @param String $sql_query
     * @return Boolean
     */
    static public function is_cached($sql_query) {
        return isset(self::$data[md5($sql_query)]);
    }

    /**
     * Returns a previusly STORED SQL RESULT by SQL QUERY if exist
     * @param String $sql_query
     * @return Array returns FALSE if not exist
     */
    static public function get_result($sql_query) {
        if (isset(self::$data[md5($sql_query)])) {
            return (self::$data[md5($sql_query)]);
        } else {
            return false;
        }
    }

}
