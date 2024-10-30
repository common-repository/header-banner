<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Textarea field.
 *
 * @since 1.0.0
 */
class Textarea extends Field {

	/**
	 * Render a field.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function field() {

		wp_editor(
			$this->get_value(),
			'text-' . $this->args['id'],
			[
				'textarea_name'  => $this->get_name(),
				'textarea_rows'  => 8,
				'wpautop'        => false,
				'default_editor' => 'tinymce',
			]
		);
	}
}