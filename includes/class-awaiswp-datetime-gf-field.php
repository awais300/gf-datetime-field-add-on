<?php

namespace Awaiswp\Field;

if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * This class is responsible for adding a new field type "awaiswp_datetime".
 */
class Awaiswp_DateTime_GF_Field extends \GF_Field {

	/**
	 * @var String $type The field type.
	 */
	public $type = 'awaiswp_datetime';

	/**
	 * Return the field title, for use in the form editor.
	 *
	 * @return String
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'Date-Time', 'datetimefieldaddon' );
	}

	/**
	 * Assign the field button to the Advanced Fields group.
	 *
	 * @return array
	 */
	public function get_form_editor_button() {
		return array(
			'group' => 'advanced_fields',
			'text'  => $this->get_form_editor_field_title(),
		);
	}

	/**
	 * The settings which should be available on the field in the form editor.
	 *
	 * @return Array
	 */
	function get_form_editor_field_settings() {
		return array(
			'label_setting',
			'description_setting',
			'rules_setting',
			'placeholder_setting',
			'error_message_setting',
			'label_placement_setting',
			'sub_label_placement_setting',
			'input_class_setting',
			'css_class_setting',
			'size_setting',
			'admin_label_setting',
			'default_value_setting',
			'visibility_setting',
			'conditional_logic_field_setting',
			'prepopulate_field_setting',
		);
	}

	/**
	 * Enable this field for use with conditional logic.
	 *
	 * @return bool
	 */
	public function is_conditional_logic_supported() {
		return true;
	}

	/**
	 * Define the fields inner markup.
	 *
	 * @param Array $form The Form Object currently being processed.
	 * @param String|Array $value The field value. From default/dynamic population, $_POST, or a resumed incomplete submission.
	 * @param null|array $entry Null or the Entry Object currently being edited.
	 *
	 * @return String
	 */
	public function get_field_input( $form, $value = '', $entry = null ) {
		$id              = absint( $this->id );
		$form_id         = absint( $form['id'] );
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		// Prepare the value of the input ID attribute.
		$field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$value = esc_attr( $value );

		// Get the value of the inputClass property for the current field.
		$inputClass = $this->inputClass;

		// Prepare the input classes.
		$size         = $this->size;
		$class_suffix = $is_entry_detail ? '_admin' : '';
		$class        = $size . $class_suffix . ' ' . $inputClass;

		// Prepare the other input attributes.
		$tabindex              = $this->get_tabindex();
		$logic_event           = ! $is_form_editor && ! $is_entry_detail ? @$this->get_conditional_logic_event( 'keyup' ) : '';
		$placeholder_attribute = $this->get_field_placeholder_attribute();
		$required_attribute    = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute     = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		$disabled_text         = $is_form_editor ? 'disabled="disabled"' : '';

		// Prepare the input tag for this field.
		$input = "<input name='input_{$id}' id='{$field_id}' type='text' value='{$value}' class='awp_datetimepicker {$class}' {$tabindex} {$logic_event} {$placeholder_attribute} {$required_attribute} {$invalid_attribute} {$disabled_text}/>";

		return sprintf( "<div class='ginput_container ginput_container_%s'>%s</div>", $this->type, $input );
	}
}

\GF_Fields::register( new Awaiswp_DateTime_GF_Field() );
