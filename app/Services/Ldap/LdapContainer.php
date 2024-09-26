<?php

namespace App\Services\Ldap;

use LdapRecord\Container;
use LdapRecord\Connection;

class LdapContainer
{
    public function bind()
    {
        $connection = new Connection([
            'hosts'    => [$this->host()],
            'username' => $this->username(),
            'password' => $this->password(),
        ]);
        $connection->connect();

        Container::addConnection($connection);
    }

    private function host()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sukat']['host'];
    }

    private function username()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sukat']['username'];
    }

    private function password()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sukat']['password'];
    }
}
