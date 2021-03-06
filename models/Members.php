<?php

/**
 *
 */

class Members
{
    private $table = "users";
    private $id_column = "user_id";

    public function __construct()
    {
    }

    public function get($id = 0, $columns = [])
    {
        $columns = empty($columns) ? '*' : implode(',', $columns);
        if ($id != 0) {
            $sql = "SELECT ${columns} FROM {$this->table} WHERE {$this->id_column} = $id";
        } else {
            $sql = "SELECT ${columns} FROM {$this->table}";
        }
        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_members()
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_type = 'miembro'";
        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_admins()
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_type = 'administrador'";
        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function search_user($username = '')
    {
        $sql = "SELECT user_id, avatar, username, first_name, last_name, email FROM {$this->table} WHERE username LIKE '%{$username}%' OR email = '$username' ORDER BY username ASC";
        if (empty($username)) {
            $sql = "SELECT user_id, avatar, username, first_name, last_name, email FROM {$this->table} ORDER BY username ASC";
        }

        $result = execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function check_user($login, $password, $encrypt_password = true)
    {
        $password = $encrypt_password ? md5($password) : $password;
        $column = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $sql = "SELECT * FROM {$this->table} WHERE $column = '$login' AND `password` = '$password'";
        $result = execute_query($sql);
        if ($result) {
            return $result->fetch_object();
        }

        return null;
    }

    public function check_exist_credential($credential)
    {
        $column = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $sql = "SELECT * FROM {$this->table} WHERE $column = '$credential'";
        $result = execute_query($sql);
        if ($result->fetch_object() != null) {
            return true;
        }

        return false;
    }

    public function check_exist_reset_code($reset_code = '')
    {
        if (empty($reset_code)) {
            return false;
        }

        $sql = "SELECT user_id FROM {$this->table} WHERE reset_code = '$reset_code'";
        $result = execute_query($sql);
        if ($result->fetch_object() != null) {
            return true;
        }

        return false;
    }

    public function set_reset_code($email = '', $reset_code = '')
    {
        if (empty($reset_code) || empty($email)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET reset_code = '$reset_code' WHERE email = '$email'";
        $result = execute_query($sql);
        return $result;
    }

    public function check_google_id($google_id, $email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE google_id = $google_id OR email = '$email'";
        $result = execute_query($sql);
        if ($result) {
            return $result->fetch_object();
        }

        return null;
    }

    public function create($data = [], $columns = [])
    {
        if (empty($data)) {
            return false;
        }

        $columns = implode(',', $columns);
        extract($data);
        $password = md5($password);
        $sql = "INSERT INTO {$this->table} ($columns) VALUES('$username','$first_name', '$last_name', '$email', '$gender', '$birthdate', '$user_type', '$password')";
        $result = execute_query_return_id($sql);
        return $result;
    }

    public function create_with_google($data = [], $columns = [])
    {
        if (empty($data)) {
            return false;
        }

        $columns = implode(',', $columns);
        extract($data);
        $password = md5($password);
        $sql = "INSERT INTO {$this->table} ($columns) VALUES('$google_id', '$avatar','$first_name', '$last_name', '$email', '$gender', '$user_type', '$password')";
        $result = execute_query_return_id($sql);
        return $result;
    }

    public function create_just_email($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $password = md5($password);
        $sql = "INSERT INTO {$this->table} (email, first_name, last_name, password) VALUES('$email', '$first_name', '$last_name', '$password')";
        $result = execute_query_return_id($sql);
        return $result;
    }

    public function edit($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $user_type = empty($user_type) ? 'miembro' : $user_type;
        $sql = "UPDATE {$this->table} SET username = '$username', first_name = '$first_name', last_name = '$last_name', email = '$email', gender = '$gender', birthdate = '$birthdate', user_type = '$user_type' WHERE {$this->id_column} = $id;";
        if (isset($data['password'])) {
            $password = md5($password);
            $sql = "UPDATE {$this->table} SET first_name = '$first_name', last_name = '$last_name', email = '$email', gender = '$gender', birthdate = '$birthdate', user_type = '$user_type', password = '$password' WHERE {$this->id_column} = $id;";
        }
        $result = execute_query($sql);
        return $result;
    }

    public function edit_profile($id, $data = [])
    {
        if (empty($data) or empty($id)) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET username = '$username', first_name = '$first_name', last_name = '$last_name', email = '$email', gender = '$gender', birthdate = '$birthdate' WHERE {$this->id_column} = $id;";
        if (isset($data['password']) and $data['password'] != "") {
            $password = md5($password);
            $sql = "UPDATE {$this->table} SET username = '$username', first_name = '$first_name', last_name = '$last_name', email = '$email', gender = '$gender', birthdate = '$birthdate', password = '$password' WHERE {$this->id_column} = $id;";
        }
        $result = execute_query($sql);
        return $result;
    }

    public function edit_password($id = 0, $password = '')
    {
        if (empty($id) or empty($password)) {
            return false;
        }

        $password = md5($password);
        $sql = "UPDATE {$this->table} SET password = '$password' WHERE {$this->id_column} = $id";
        $result = execute_query($sql);
        return $result;
    }

    public function reset_password($password = '', $reset_code = '')
    {
        if (empty($password) || empty($reset_code)) {
            return false;
        }

        $password = md5($password);
        $sql = "UPDATE {$this->table} SET password = '$password' WHERE reset_code = '$reset_code'";
        $result = execute_query($sql);
        return $result;
    }

    public function update_avatar($id, $file_name)
    {
        if (empty($file_name) or empty($id)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET avatar = '$file_name' WHERE {$this->id_column} = $id;";
        $result = execute_query($sql);
        return $result;
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
        $result = execute_query($sql);
        return $result;
    }

    public function get_full_name($full_name = '')
    {
        if (empty($full_name)) {
            return ['first_name' => '', 'last_name' => ''];
        }

        $names = explode(" ", $full_name);
        switch (count($names)) {
            case 1:
                $names = ['first_name' => $names[0], 'last_name' => ''];
                break;

            case 2:
                $names = ['first_name' => $names[0], 'last_name' => $names[1]];
                break;

            case 3:
                $names = ['first_name' => $names[0] . ' ' . $names[1], 'last_name' => $names[2]];
                break;

            case 4:
                $names = ['first_name' => $names[0] . ' ' . $names[1], 'last_name' => $names[2] . ' ' . $names[3]];
                break;

            default:
                $first_name = ['first_name' => $names[0] . ' ' . $names[1]];
                $l_name = '';
                for ($i = 2; $i < count($names); $i++) {
                    if ($i == 2) {
                        $l_name = $names[2];
                        continue;
                    }
                    $l_name .= ' ' . $names[$i];
                }
                $last_name = ['last_name' => $l_name];
                $names = [$first_name, $last_name];
                break;
        }
        return $names;
    }

}
