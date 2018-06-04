<?php

/*
   Class: QodeTaxonomyField
   A class that initializes Qode Taxonomy Field
*/
class QodeTaxonomyField implements iRender{
    private $type;
	private $name;
	private $label;
	private $description;
	private $options = array();
	private $args = array();

	function __construct($type,$name,$label="",$description="", $options = array(), $args = array()) {
		$this->type = $type;
		$this->name = $name;
		$this->label = $label;
		$this->description = $description;
		$this->options = $options;
		$this->args = $args;
		add_filter('qode_taxonomy_fields',array($this,'addFieldForEditSave'));
	}

	public function addFieldForEditSave($names){
        $names[] = $this->name;
        return $names;
    }

	public function render($factory) {
	    $factory->render( $this->type, $this->name, $this->label, $this->description, $this->options, $this->args );
	}
}

abstract class QodeTaxonomyFieldType {
	abstract public function render( $name, $label="",$description="", $options = array(), $args = array());
}

class QodeTaxonomyFieldText extends QodeTaxonomyFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array() ) {
		if(!isset( $_GET['tag_ID'])){ ?>
            <div class="form-field">
                <label for="<?php echo esc_html($name); ?>"><?php echo esc_html($label); ?></label>
                <input type="text" name="<?php echo esc_html($name); ?>" id="<?php echo esc_html($name); ?>" value="">
                <p class="description"><?php echo esc_html($description); ?></p>
            </div>
        <?php
        }else {
			$value = get_term_meta( $_GET['tag_ID'], $name, true );
		    ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="<?php echo esc_html($name); ?>"><?php echo esc_html($label); ?></label></th>
                <td>
                    <input type="text" name="<?php echo esc_html($name); ?>" id="<?php echo esc_html($name); ?>" value="<?php echo $value ? $value : ''; ?>">
                    <p class="description"><?php echo esc_html($description); ?></p>
                </td>
            </tr>
        <?php
		}
	}
}

class QodeTaxonomyFieldImage extends QodeTaxonomyFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array() ) {
		if(!isset( $_GET['tag_ID'])){ ?>
            <div class="form-field">
                <label for="<?php echo esc_html($name); ?>"><?php echo esc_html($label); ?></label>
                <input type="hidden" name="<?php echo esc_html($name); ?>" id="<?php echo esc_html($name); ?>" class="qode-tax-custom-media-url" value="">
                <div class="qode-tax-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary qode-tax-media-add" name="qode-tax-media-add" value="<?php esc_html_e( 'Add Image', 'qode' ); ?>" />
                    <input type="button" class="button button-secondary qode-tax-media-remove" name="qode-tax-media-remove" value="<?php esc_html_e( 'Remove Image', 'qode' ); ?>" />
                </p>
            </div>
			<?php
		}else {
			global $taxonomy;
			$image_id = get_term_meta ( $_GET['tag_ID'], $name, true );
			?>
            <tr class="form-field">
                <th scope="row">
                    <label for="<?php echo esc_html($name); ?>"><?php echo esc_html($label); ?></label>
                </th>
                <td>
					<?php  ?>
                    <input type="hidden" name="<?php echo esc_html($name); ?>" id="<?php echo esc_html($name); ?>" value="<?php echo $image_id; ?>" class="qode-tax-custom-media-url">
                    <div class="qode-tax-image-wrapper">
						<?php if ( $image_id ) { ?>
							<?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
						<?php } ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary qode-tax-media-add" name="qode-tax-media-add" value="<?php esc_html_e( 'Add Image', 'qode' ); ?>" />
                        <input data-termid="<?php echo esc_html($_GET['tag_ID']); ?>" data-taxonomy="<?php echo esc_html($taxonomy); ?>" type="button" class="button button-secondary qode-tax-media-remove" name="qode-tax-media-remove" value="<?php esc_html_e( 'Remove Image', 'qode' ); ?>" />
                    </p>
                </td>
            </tr>
			<?php
		}
	}
}

class QodeTaxonomyFieldColor extends QodeTaxonomyFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array() ) {

		if(!isset( $_GET['tag_ID'])){ ?>
            <div class="form-field">
                <label for="<?php echo esc_html($name); ?>"><?php echo esc_html($label); ?></label>
                <input type="text" name="<?php echo esc_html($name); ?>" id="<?php echo esc_html($name); ?>" value="" class="qode-taxonomy-color-field">
                <p class="description"><?php echo esc_html($description); ?></p>
            </div>
			<?php
		}else {
			$value = get_term_meta( $_GET['tag_ID'], $name, true );
			?>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="<?php echo esc_html($name); ?>"><?php echo esc_html($label); ?></label></th>
                <td>
                    <input type="text" name="<?php echo esc_html($name); ?>" id="<?php echo esc_html($name); ?>" value="<?php echo $value ? $value : ''; ?>" class="qode-taxonomy-color-field">
                    <p class="description"><?php echo esc_html($description); ?></p>
                </td>
            </tr>
			<?php
		}

	}
}

class QodeTaxonomyFieldFactory {

	public function render( $field_type, $name, $label="", $description="", $options = array(), $args = array(), $hidden = false) {

		switch ( strtolower( $field_type ) ) {

			case 'text':
				$field = new QodeTaxonomyFieldText();
				$field->render( $name, $label, $description, $options, $args, $hidden );
				break;

			case 'image':
				$field = new QodeTaxonomyFieldImage();
				$field->render( $name, $label, $description, $options, $args, $hidden );
				break;

			case 'color':
				$field = new QodeTaxonomyFieldColor();
				$field->render( $name, $label, $description, $options, $args, $hidden );
				break;
			default:
				break;

		}
	}
}
