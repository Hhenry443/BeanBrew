<?php

namespace Framework;

use Framework\Session;

class Authorisation
{
    /**
     * Check if current login user owns a resource
     * 
     * @param int resoourceID
     * @return bool
     */
    public static function isOwner($resourceId)
    {
        $sessionUser = Session::get('user');
        if ($sessionUser !== null && isset($sessionUser['id'])) {
            $sessionUserId = (int) $sessionUser['id'];
            return $sessionUserId === $resourceId;
        }

        return false;
    }
}
