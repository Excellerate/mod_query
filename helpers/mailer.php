<?php

    class QueryHelperMailer{

        static function send($params, $post){

            // We dont need the following
            unset($post['birthday'], $post['token']);

            // Clean up
            $to  = $params->get('to_a');
            $cc  = $params->get('cc_a');
            $bcc = $params->get('bcc_a');
            $subject = $params->get('subject');

            // Build up body
            if(is_array($post)){

                foreach($post as $key => $value){
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

            // Mail it
            $app        = JFactory::getApplication();
            $mailfrom   = trim($post['email']);
            $fromname   = (isset($post['name']) and !empty($post['name'])) ? $post['name'] : false;
            $sitename   = $app->getCfg('sitename');
            $htmlBody   = "<h4>The following information has been submitted from the " . $sitename . " website</h4>" . $body;
            $textBody   = strip_tags($htmlBody);
            
            // Set mailgun settings
            $mailGunSettings = array(
                'domain' => $params->get('domain'),
                'key' => $params->get('key')
              );

            // Use Mailgun instead
            $fcc  = !empty($cc) ? "-F cc='".$cc."'" : false;
            $fbcc = !empty($bcc) ? "-F bcc='".$bcc."'" : false;
            $execString = "curl -s --user 'api:".$mailGunSettings['key']."' https://api.mailgun.net/v3/".$mailGunSettings['domain']."/messages -F from='".$mailfrom."' -F to='".$to."' ".$fcc." ".$fbcc." -F subject='".$subject."' -F text='".$textBody."' --form-string html='".$htmlBody."'";
            $r = shell_exec($execString);
        }
    }