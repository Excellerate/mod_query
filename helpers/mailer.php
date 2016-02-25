<?php

    class QueryHelperMailer{

        static function send($tos, $ccs, $bccs, $subject, $data){

            // We dont need the following
            unset($data['birthday'], $data['token']);

            // Clean up
            $tos = array_filter($tos);
            $ccs = array_filter($ccs);
            $bccs = array_filter($bccs);

            // Build up body
            if(is_array($data)){

                foreach($data as $key => $value){
                    if($key !== "message"){
                        $body[] = "<u>".ucwords(str_replace("_", " ", $key)) . "</u>: " . $value;
                    }
                    else{
                        $prepend = $value;
                    }
                }

                // Append IP address
                $body[] = "<u>IP Address</u>: " . $_SERVER['REMOTE_ADDR'];
                $body = (isset($prepend) ? "<p>".$prepend."</p>" : null) . implode("<br>", $body);
            }
            else{
                throw new Excetion("Array expected");
            }

            // App
            $app        = JFactory::getApplication();
            $mailfrom   = trim($data['email']);
            $fromname   = (isset($data['name']) and !empty($data['name'])) ? $data['name'] : false;
            $sitename   = $app->getCfg('sitename');

            // Mail it
            $mail = JFactory::getMailer();
            $mail->isHTML(true);
            $mail->addRecipient($tos);
            $mail->AddCC($ccs);
            $mail->AddBCC($bccs);
            $mail->setSender(array($mailfrom, $fromname));
            $mail->setSubject($sitename.': '.$subject);
            $mail->setBody("<h4>The following information has been submitted from the " . $sitename . " website</h4>" . $body);

            // Send it
            if( ! $mail->Send() ){
                return false;
            }
            else{
                return true;
            }
        }
    }