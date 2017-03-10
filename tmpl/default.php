<?php if($showHeading) : ?>
<h3 class="ui devided header" style="margin-top:-15px;"><?= $heading; ?>
    <div class="ui sub header"><?= $subHeading; ?></div>
</h3>
<?php endif; ?>
<form class="ui query form" action="<?php print Juri::current();?>" method="post">
    
    <div class="required field">
        <label>Full name:</label>
        <input type="text" name="query[name]" placeholder="Full name...">
    </div>
    
    <div class="required field">
        <label>Phone Number:</label>
        <input type="text" name="query[number]" placeholder="Phone number...">
    </div>

    <div class="required field">
        <label>Email address:</label>
        <input type="email" name="query[email]" placeholder="Email address...">
    </div>

    <?php if($showSuburb) : ?>
    <div class="required field">
        <label>Suburb:</label>
        <input type="email" name="query[suburb]" placeholder="Enter a suburb name...">
    </div>
    <?php endif; ?>

    <?php if($showProvince) : ?>
    <div class="required field">
        <label>Province:</label>
        <div id="suburbs" class="ui fluid selection dropdown">
            <input type="hidden" name="query[province]">
            <div class="default text">Province</div>
            <i class="dropdown icon"></i>
            <div class="menu">
                <div class="item" data-value="kwazulu-natal">Kwazulu Natal</div>
                <div class="item" data-value="gauteng">Gauteng</div>
                <div class="item" data-value="western-cape">Western Cape</div>
                <div class="item" data-value="eastern-cape">Eastern Cape</div>
                <div class="item" data-value="limpopo">Limpopo</div>
                <div class="item" data-value="Other">Other</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($showMessage) : ?>
    <div class="field">
        <textarea name="query[message]" placeholder="Message"></textarea>
    </div>
    <?php endif; ?>

    <?php if($showBuySell) : ?>
    <div class="field">
        <div id="suburbs" class="ui fluid selection dropdown">
            <input type="hidden" name="query[buysell]">
            <div class="default text">Interested in</div>
            <i class="dropdown icon"></i>
            <div class="menu">
                <div class="item" data-value="buying">Buying</div>
                <div class="item" data-value="selling">Selling</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($requestSpecial) : ?>
    <div class="field">
        <label>Special interested in:</label>
        <input type="email" name="query[special]" value="<?= $articleTitle ? : null; ?>" placeholder="Special...">
    </div>
    <?php endif; ?>
    
    <div class="ui error message">
        <div class="header">We noticed some issues</div>
    </div>

    <div class="ui right labeled query icon submit small button">Submit<i class="right arrow icon"></i></div>

    <input type="hidden" name="query[birthday]" value="" style="display:none;" />

    <input type="hidden" name="query[token]" value="<?php print uniqid(); ?>" />

</form>

<script>

    // Ready state 
    jQuery(document).ready(function() {
        
        // Dropdowns
        $('#suburbs').dropdown();

        // Numbers only for phone number
        jQuery("input[name='query[number]']").keydown(function (e) {
            var key = e.which || e.keyCode;

            if (
                !e.shiftKey && !e.altKey && !e.ctrlKey &&
                // numbers
                key >= 48 && key <= 57 ||
                // Numeric keypad
                key >= 96 && key <= 105 ||
                // comma, period and minus, . on keypad
                key == 190 || key == 188 || key == 109 || key == 110 ||
                // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
                // Home and End
                key == 35 || key == 36 ||
                // left and right arrows
                key == 37 || key == 39 ||
                // Del and Ins
                key == 46 || key == 45
            ){
                return true;
            }else{
                return false;
            }
        });

        // Validation
        $('.ui.query.form').form({
            fields: {
                fullName: {
                identifier  : 'query[name]',
                rules: [{
                        type   : 'empty',
                        prompt : 'Please enter your full name'
                    }]
                },
                number: {
                identifier  : 'query[number]',
                rules: [{
                        type   : 'empty',
                        prompt : 'Please enter your contact number'
                    },{
                        type : 'length[10]',
                        prompt : 'Your contact number is too short'
                    },{
                        type : 'maxLength[10]',
                        prompt : 'Your contact number is too long'
                    }]
                },
                email: {
                identifier  : 'query[email]',
                rules: [{
                        type   : 'empty',
                        prompt : 'Please enter your email address'
                    },{
                        type   : 'email',
                        prompt : 'Please enter a valid email address'
                    }]
                },
                province: {
                identifier  : 'query[province]',
                rules: [{
                        type   : 'empty',
                        prompt : 'Please enter your province'
                    }]
                },
                suburb: {
                identifier  : 'query[suburb]',
                rules: [{
                        type   : 'empty',
                        prompt : 'Please enter your your suburb'
                    }]
                }
            }
        });

        // Submit the form on click
        jQuery(".ui.query.button").click(function(){
            jQuery(".ui.query.form").submit();
        });

    });

</script>