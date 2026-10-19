<?php

class Backup extends dbBasic
{
    function __construct()
    {
        $this->pkey = "backup_id";
        $this->tbl = DB_PREFIX . "backup";
    }
}
