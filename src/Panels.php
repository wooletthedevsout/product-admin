<?php 

namespace Wooletthedevsout\Product\Admin;

class Panels
{
	protected $tabName;

	public $tab_id;

	public $context;

	public $forms;

	public $meta_fields = [];

	public function __construct(string $tabName, string $tab_id, array $forms)
	{
		$this->tab_id = $tab_id;
		$this->forms = $forms;

		foreach($forms as $form) {
			$this->meta_fields[] = $form[1] . '_' . $form[0];
		}

		$this->context = '<div id="' . $tab_id . '" class="panel woocommerce_options_panel" style="padding-left: 10px;">';
		add_action('woocommerce_product_data_panels', [$this, 'render']);
		add_action('woocommerce_process_product_meta', [$this, 'save']);
	}

	public function render()
	{
		echo $this->context; 
		$this->forms($this->forms);

		?></div><?php
	}

	public function addTitle(string $title)
	{
		$this->context .= '<h4>' . $title . '</h4>';
	}

	public function forms($forms)
	{
		foreach ($forms as $form) {
			if(in_array('checkbox', $form)) {
				woocommerce_wp_checkbox(array(
					'id' => $form[1] . '_checkbox', 
					'label' => __($form[2], 'woocommerce'),
					'desc_tip' => 'true',
					'description' => __($form[3], 'woocommerce')));
			}
			if(in_array('text', $form)) {
				woocommerce_wp_text_input(array(
					'id' => $form[1] . '_text', 
					'label' => __($form[2], 'woocommerce'),
					'desc_tip' => 'true',
					'description' => __($form[3], 'woocommerce'),
					'type' => 'text'
				));
			}
			if(in_array('number', $form)) {
				woocommerce_wp_text_input(array(
					'id' => $form[1] . '_number', 
					'label' => __($form[2], 'woocommerce'),
					'desc_tip' => 'true',
					'description' => __($form[3], 'woocommerce'),
					'type' => 'number'
				));
			}
			if(in_array('textarea', $form)) {
				woocommerce_wp_textarea_input(array(
					'id' => $form[1] . '_textarea', 
					'label' => __($form[2], 'woocommerce'),
					'desc_tip' => 'true',
					'description' => __($form[3], 'woocommerce'),
				));
			}
			if(in_array('select', $form)) {
				woocommerce_wp_select(array(
					'id' => $form[1] . '_select', 
					'label' => __($form[2], 'woocommerce'),
					'desc_tip' => 'true',
					'description' => __($form[3], 'woocommerce'),
					'options' => $form[4]
				));
			}
			if(in_array('radio', $form)) {
				woocommerce_wp_radio(array(
					'id' => $form[1] . '_radio', 
					'label' => __($form[2], 'woocommerce'),
					'options' => $form[3]
				));
			}
		}
	}

	public function save($post_id)
	{
		$product = wc_get_product($post_id);

		foreach ($this->meta_fields as $field) {
		
			if(isset($_POST[$field])) {
				$product->update_meta_data($field, $_POST[$field]);
			}	
		}	

		$product->save();
	}
}