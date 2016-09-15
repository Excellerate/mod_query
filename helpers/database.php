<?php

    class QueryHelperDatabase{

        static function save($data){

            // Find database prefix and pull all tables
            $app = JFactory::getApplication();
            $prefix = $app->getCfg('dbprefix');
            $tables = JFactory::getDbo()->getTableList();

            // Get database
            $db = JFactory::getDbo();

            // Build table if it does not exist
            if( ! in_array($prefix.'form_queries', $tables) ){

                $db->setQuery(
                    "CREATE TABLE IF NOT EXISTS `".$prefix."form_queries` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(220) DEFAULT NULL,
                        `number` varchar(220) DEFAULT NULL,
                        `email` varchar(220) DEFAULT NULL,
                        `suburb` varchar(220) DEFAULT NULL,
                        `province` varchar(220) DEFAULT NULL,
                        `message` varchar(220) DEFAULT NULL,
                        `buysell` varchar(220) DEFAULT NULL,
                        `token` varchar(32) NOT NULL,
                        `ip` varchar(11) NOT NULL,
                        `created_at` datetime NOT NULL,
                        `updated_at` datetime NOT NULL,
                    PRIMARY KEY (`id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
                );

                $db->execute();
            }

            // Check if the record was already entered
            $query = $db->getQuery(true);
            $query->select($db->quoteName(array('token')));
            $query->from($db->quoteName($prefix.'form_queries'));
            $query->where($db->quoteName('token') . ' = '. $db->quote($data['token']));
            $db->setQuery($query);
            $results = $db->loadObjectList();



             // Record the data
            if(count($results) == 0){
                $query = $db->getQuery(true);
                $columns = array('name', 'number', 'email', 'suburb', 'province', 'message', 'buysell', 'token', 'ip', 'created_at', 'updated_at');
                $values = array(
                    (isset($data['name']) ? $db->quote($data['name']) : "NULL"),
                    (isset($data['number']) ? $db->quote($data['number']) : "NULL"),
                    (isset($data['email']) ? $db->quote($data['email']) : "NULL"),
                    (isset($data['suburb']) ? $db->quote($data['suburb']) : "NULL"),
                    (isset($data['province']) ? $db->quote($data['province']) : "NULL"),
                    (isset($data['message']) ? $db->quote($data['message']) : "NULL"),
                    (isset($data['buysell']) ? $db->quote($data['buysell']) : "NULL"),
                    $db->quote($data['token']),
                    $db->quote($_SERVER['REMOTE_ADDR']),
                    $db->quote(date('Y-m-d H:i:s', time())),
                    $db->quote(date('Y-m-d H:i:s', time()))
                );
                $query
                    ->insert($db->quoteName($prefix.'form_queries'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $values));
                $db->setQuery($query);
                $db->execute();

                // You may email this form
                return true;
            }

            // Nope
            return false;
        } 
    }