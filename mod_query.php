<?php

/**
 * Web Query Module Entry Point
 * 
 * @package    Joomla
 * @subpackage Modules
 * @license    MIT
 * @link
 *     
 */
 
// No direct access
defined('_JEXEC') or die;

// Load vendors
include 'vendor/autoload.php';

// Load helpers
include 'helpers/db.php';
include 'helpers/mailer.php';

// Gather FuelPHP
use Fuel\Validation\Validator;

// Settings
$showSuburb = $params->get('suburb', false);
$showProvince = $params->get('province', false);
$showMessage = $params->get('message', false);
$showBuySell = $params->get('buysell', false);

if($showHeading = $params->get('heading')){
    $heading = $params->get('heading', false);
    $subHeading = $params->get('subheading', false);
}

// Check for post data
if($post = JRequest::getVar('query', false, 'post')){

    // Check honeypot
    if( ! empty($_POST['birthday']) ){
        return true;
    }

    // Validate
    $val = new Validator;
    $val->addField('name')->required();
    $val->addField('number')->required()->number();
    $showSuburb ? $val->addField('suburb')->required() : null;
    $showProvince ? $val->addField('province')->required() : null;
    $result = $val->run($post);
    if($result->isValid()){

        // Save data
        QueryHelperDB::save($post);

        // Email data
        QueryHelperMailer::send(
            array(
                $params->get('to_a'), 
                $params->get('to_b'), 
                $params->get('to_c')
            ),
            array(
                $params->get('cc_a'), 
                $params->get('cc_b'), 
                $params->get('cc_c')
            ),
            array(
                $params->get('bcc_a'), 
                $params->get('bcc_b'), 
                $params->get('bcc_c')
            ),
            $params->get('subject'),
            $post
        );

        // We done
        print '<div class="ui message"><i class="ui circular checkmark icon"></i>Sent successfully, we will be in touch.</div>';

        // Message
        JFactory::getApplication()->enqueueMessage('Please check that all required fields have been completed.', 'success');
    }

}

// Display data
ob_start();
    require JModuleHelper::getLayoutPath('mod_query', 'default');
    $get = ob_get_contents();
ob_end_clean();
print preg_replace("({{ ?form ?}})", $get, $params->get('template'));