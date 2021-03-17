<?php

namespace Awaiswp\Settings;

if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * This class is responsible for adding an custom date format field.
 */
class Awaiswp_DateTime_Field_Settings {

	/**
	 * Init hooks
	 */
	public function __construct() {

		add_action( 'gform_field_standard_settings', array( $this, 'datetime_field_standard_settings' ), 10, 2 );
		add_action( 'gform_editor_js', array( $this, 'datetime_field_editor_script' ) );

		add_filter( 'gform_tooltips', array( $this, 'datetime_add_tooltips' ) );
		add_filter( 'gform_pre_render', array( $this, 'datetime_add_gf_form_script' ) );
	}

	/**
	 * Adds a sub field inside the custom date time GF field type.
	 *
	 * @param int $position
	 * @param int $form_id
	 *
	 */
	function datetime_field_standard_settings( $position, $form_id ) {

		// Create settings on position 25 (right after Field Label).
		if ( $position == 25 ) {
			?>
            <li class="datetime_format_value_setting field_setting">
                <label for="field_admin_label" class="section_label"
                       onclick="document.getElementById('field_datetime_format_value').focus()">
					<?php esc_html_e( 'Enter Date Time Format', 'datetimefieldaddon' ); ?>
					<?php gform_tooltip( 'form_field_datetime_format_value' ); ?>
                </label>
                <input type="text"
                       placeholder="<?php echo esc_attr__( 'Default: MM/DD/YYYY h:mm a', 'datetimefieldaddon' ); ?>"
                       class="fieldwidth-3" id="field_datetime_format_value"
                       onchange="SetFieldProperty('datetime_format', this.value);"/>
            </li>
			<?php
		}
	}

	/**
	 * Add GF way to save custom fields for type custom type "awaiswp_datetime".
	 *
	 */
	public function datetime_field_editor_script() {
		?>
        <script type='text/javascript'>
            // Adding setting to fields of type "awaiswp_datetime".
            fieldSettings.awaiswp_datetime += ', .datetime_format_value_setting';

            // Make sure our field gets populated with its saved value.
            jQuery(document).on("gform_load_field_settings", function (event, field, form) {
                jQuery("#field_datetime_format_value").val(field.datetime_format);
            });
        </script>
		<?php
	}

	/**
	 * Add tooltip for custom field.
	 *
	 * @param Array $tooltips
	 *
	 * @return Array
	 */
	public function datetime_add_tooltips( $tooltips ) {
		$tooltips['form_field_datetime_format_value'] = esc_html__( "Moment.js tokens (formats) are allowed. e.g.: 'MMMM Do YYYY [at] h:mm: a' - That would print something like: 'August 13th 2020 at 5:20 am' <br/> To see the moment.js date time format click <a target='_blank' href='https://momentjs.com/docs/#/parsing/string-format/'>here</a>", 'datetimefieldaddon' );

		return $tooltips;
	}


	/**
	 * Add JS before form render for each custom field to apply date time format.
	 *
	 * @param Array $form
	 *
	 * @return Array
	 */
	public function datetime_add_gf_form_script( $form ) {
		$allow_custom_js = gf_apply_filters( array( 'gf_awp_datetimepicker_script', $form['id'] ), true, $form );

		if ( ! $allow_custom_js ) {
			return $form;
		}

		$dateime_fields = array();
		foreach ( $form['fields'] as $key => $field ) {
			// Only apply JS for "Awaiswp_DateTime_GF_Field" type.
			if ( $field instanceof \Awaiswp\Field\Awaiswp_DateTime_GF_Field ) {
				$id = 'input_' . absint( $field->formId ) . '_' . absint( $field->id );

				if ( isset( $field->datetime_format ) ) {
					$dateime_fields[ $id ] = esc_html( trim( $field->datetime_format ) );
				} else {
					$dateime_fields[ $id ] = '';
				}
			}
		}

		?>
		<?php if ( ! empty( $dateime_fields ) ) : ?>

            <script type="text/javascript">
                jQuery(document).ready(function ($) {
					<?php
					foreach ( $dateime_fields as $key => $format ) {
						if ( empty( $format ) ) {
							echo "$('#{$key}').datetimepicker({
						        'format': 'MM/DD/YYYY h:mm a',
						        'formatTime':'h:mm a',
						  		'formatDate':'DD.MM.YYYY'
						    });";
						} else {
							echo "$('#{$key}').datetimepicker({
						        'format': '{$format}',
						        'formatTime':'h:mm a',
						  		'formatDate':'DD.MM.YYYY'
						    });";
						}
					}
					?>
                });
            </script>

            <script type="text/javascript">
                jQuery(document).on('gform_post_render', function (event, form_id, current_page) {
                    jQuery('.awp_datetimepicker').datetimepicker('destroy');

					<?php
					foreach ( $dateime_fields as $key => $format ) {
						if ( empty( $format ) ) {
							echo "jQuery('#{$key}').datetimepicker({
						        'format': 'MM/DD/YYYY h:mm a',
						        'formatTime':'h:mm a',
						  		'formatDate':'DD.MM.YYYY'
						    });";
						} else {
							echo "jQuery('#{$key}').datetimepicker({
						        'format': '{$format}',
						        'formatTime':'h:mm a',
						  		'formatDate':'DD.MM.YYYY'
						    });";
						}
					}
					?>
                });
            </script>

		<?php endif; ?>
		<?php
		return $form;
	}
}

// Apply settings.
new Awaiswp_DateTime_Field_Settings();


