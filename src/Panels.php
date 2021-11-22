<?php 
/**
 * Class Panels
 * 
 * From an initial instance of Tabs, adds fields
 * to the newly included tab.
 * 
 * @since 1.0.0
 * @package Wooletthedevsout\Product\Admin
 * @author Carlos Artur Matos
 * 
 */
namespace Wooletthedevsout\Product\Admin;

class Panels implements \Countable
{
	protected $tab_name;

	public $tab_id;

	public $context;

	public $forms;

	public $meta_fields = [];

	public $after;

	public function __construct(string $tab_name, string $tab_id, array $forms)
	{
		$this->tab_id = $tab_id;
		$this->forms = $forms;

		foreach($forms as $form) {
			$this->meta_fields[] = $form[1] . '_' . $form[0];
		}

		$this->context = '<div id="' . $tab_id . '" class="panel woocommerce_options_panel" style="padding-left: 10px;">';
		add_action('woocommerce_product_data_panels', [$this, 'render']);
		add_action('woocommerce_admin_process_product_object', [$this, 'save']);
	}

	public function render()
	{
		?><?php 
			echo $this->context; 
			$this->forms($this->forms);
			echo $this->after;
		?>

		</div>
		<?php
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

	public function save($product)
	{

		foreach ($this->meta_fields as $field) {
		
			if(isset($_POST[$field])) {
				$product->update_meta_data($field, $_POST[$field]);
				$product->save_meta_data();
			}	
		}

		$product->save();

	}

	public function count()
	{
		return count($this->meta_fields);
	}

	public function addAfter(string $content)
	{
		$this->after = $content;
	}
}