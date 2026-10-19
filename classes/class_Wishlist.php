<?php

class Wishlist extends dbBasic
{
    function __construct()
    {
        $this->pkey = "wishlist_id";
        $this->tbl = DB_PREFIX . "wishlist";
    }

    function doDelete($pvalTable = 0)
    {
        // Delete
        $this->deleteOne($pvalTable);
        return 1;
    }
}
