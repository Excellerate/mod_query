<?php

    class QueryHelperDb{

        static function save($data){

            /*
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $columns = array('name', 'number', 'email', 'suburb', 'province', 'message', 'ip_address', 'token', 'created_at', 'updated_at');
            $values = array(
                $db->quote($post['name']),
                $db->quote($post['number']),
                $db->quote($post['email']),
                $db->quote($post['suburb']),
                $db->quote($post['province']),
                $db->quote($post['message']),
                $db->quote($_SERVER['REMOTE_ADDR']),
                $db->quote($post['token']),
                $db->quote(date('Y-m-d H:i:s', time())),
                $db->quote(date('Y-m-d H:i:s', time()))
            );
            $query
                ->insert($db->quoteName('#__form_assessments'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
            $db->setQuery($query);
            */
        } 
    }