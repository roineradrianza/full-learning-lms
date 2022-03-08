<?php

/**
 *
 */

class SponsorViews
{
    private $table = "sponsors_views";
    private $sponsors_table = "sponsors";
    private $sponsors_posts_table = "sponsor_post_views";
    private $id_column = "sponsor_view_id";
    private $id_course_column = "course_id";

    public function get($id = 0)
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->$id_column} = $id";
        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_views($course_id = 0)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT COUNT(sponsor_view_id) + (SELECT COUNT(country) total FROM {$this->sponsors_posts_table} 
		WHERE country = SV.country ) total, S.sponsor_name 
		FROM {$this->table} SV INNER JOIN {$this->sponsors_table} S ON  S.sponsor_id = SV.sponsor_id WHERE course_id = $course_id GROUP BY sponsor_name";
        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_course($id = 0)
    {
        if (empty($id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->$id_course_column} = $id";
        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (visitor_ip, country, sponsor_id, course_id)
    VALUES('$ip', '$country', $sponsor_id, $course_id)";
        $result = execute_query_return_id($sql);
        return $result;
    }

    public function delete($id, $lesson_id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column}";
        $result = execute_query($sql);
        return $result;
    }

}
