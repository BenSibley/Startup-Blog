jQuery(document).ready(function($){

    $('#sub-accordion-section-startup_blog_layout').find('.customize-section-description').appendTo('#customize-control-layout');

    // set context to customizer panel outside iframe site content is in
    var panel = $('html', window.parent.document);

    addLayoutThumbnails();

    // replaces radio buttons with images
    function addLayoutThumbnails() {

        // get layout inputs
        var layoutInputs = panel.find('#customize-control-layout').find('input');

        // add the appropriate image to each label
        layoutInputs.each( function() {
            $(this).parent().css('background-image', 'url("../wp-content/themes/startup-blog/assets/images/' + $(this).val() + '.png")');

            // add initial 'selected' class
            if ($(this).prop('checked')) {
                $(this).parent().addClass('selected');
            }
        });

        // watch for change of inputs (layouts)
        panel.on('click', '#customize-control-layout input', function () {
            addSelectedLayoutClass(layoutInputs, $(this));
        });
    }

    // add the 'selected' class when a new input is selected
    function addSelectedLayoutClass(inputs, target) {

        // remove 'selected' class from all labels
        inputs.parent().removeClass('selected');

        // apply 'selected' class to :checked input
        if (target.prop('checked')) {
            target.parent().addClass('selected');
        }
    }

    // *************  Repeater Control *********************

    // update Customizer based on user changes
    function customize_repeater_write($element){
        var customize_repeater_val = '';
        // combine user-entered values into one string
        $element.find('.customize_repeater_fields .customize_repeater_page_select').each(function(){
            if ( $(this).find(':selected').val() != '' ) {
                customize_repeater_val += $(this).find(':selected').val() + '|';
            }
        });
        // save the string to the hidden field and use change() to trigger an update
        $element.find('.customize_repeater_value_field').val(customize_repeater_val.slice(0, -1)).change();
    }

    // add a new dropdown selector
    function customize_repeater_add_field(e){
        e.preventDefault();
        var $control = $(this).parents('#customize-control-slider_pages');
        // $control.find('.customize_repeater_fields').append('<div class="set"><input type="text" value="" class="customize_repeater_single_field" /><a href="#" class="customize_repeater_remove_field">X</a></div>');
        $control.find('#blueprint-page-select').clone().removeAttr('id').appendTo('.customize_repeater_fields');
        $control.find('.customize_repeater_fields').append('<a href="#" class="customize_repeater_remove_field"><i class="fa fa-times-circle"></i></a>');
    }

    // update Customizer when a new option is selected
    function customize_repeater_single_field() {
        var $control = $(this).parents('#customize-control-slider_pages');
        customize_repeater_write($control);
    }

    function customize_repeater_remove_field(e){
        e.preventDefault();
        // $this = "remove" link
        var $this = $(this);
        var $control = $this.parents('#customize-control-slider_pages');
        // Remove the select dropdown
        $this.prev().remove();
        // Remove the "remove" link
        $this.remove();
        // update new value and update Customizer
        customize_repeater_write($control);
    }

    // track user input changes
    $(document).on('click', '.customize_repeater_add_field', customize_repeater_add_field)
        .on('change', '.customize_repeater_page_select', customize_repeater_single_field)
        .on('click', '.customize_repeater_remove_field', customize_repeater_remove_field);

    // Add the saved inputs right away
    $('#customize-control-slider_pages').each(function(){
        var $this = $(this);
        var repeater_saved_value = $this.find('.customize_repeater_value_field').val();
        if( repeater_saved_value.length > 0 ){
            // Page IDs are saved in hidden input and separated by pipelines (44|113|19). Split them into an array
            var repeater_saved_values = repeater_saved_value.split("|");
            // remove all existing fields in the .customize_repeater_fields container
            $this.find('.customize_repeater_fields').empty();
            // for each page ID, output the HTML for an input
            var count = 0;
            $.each(repeater_saved_values, function( index, value ) {
                // copy the hidden select "blueprint" with all pages as options
                $clone = $this.find('#blueprint-page-select').clone().removeAttr('id');
                $clone.find('option').each(function() {
                    if ( $(this).val() == value ) {
                        $(this).attr('selected', 'selected');
                    }
                });
                $clone.appendTo('.customize_repeater_fields');
                // add the link for removing fields
                if ( count != 0 ) {
                    $this.find('.customize_repeater_fields').append('<a href="#" class="customize_repeater_remove_field"><i class="fa fa-times-circle"></i></a>');
                }
                count ++;
            });
        }
    });

    // track user input changes
    $(document).on('change', '#customize-control-slider_posts_or_pages input', updateSlideSettingDisplay);

    // show/hide post/page slider settings
    function updateSlideSettingDisplay() {
        if ( $('#customize-control-slider_posts_or_pages').find('input:checked').val() == 'pages' ) {
            $('#customize-control-slider_recent_posts').addClass('hide');
            $('#customize-control-slider_post_category').addClass('hide');
            $('#customize-control-slider_pages').removeClass('hide');
        } else {
            $('#customize-control-slider_pages').addClass('hide');
            $('#customize-control-slider_recent_posts').removeClass('hide');
            $('#customize-control-slider_post_category').removeClass('hide');
        }
    }
    updateSlideSettingDisplay();
});