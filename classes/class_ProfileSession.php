<?php
class ProfileSession extends dbBasic
{
    function __construct()
    {
        $this->pkey = "profile_session_id";
        $this->tbl = DB_PREFIX . "profile_session";
    }
}
