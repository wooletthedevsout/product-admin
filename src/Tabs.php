<?php 
/**
 * Class Tabs
 * 
 * Manage new and customized tabs within Woocommerce
 * products edit page.
 * 
 * @since 1.0.0
 * @package Wooletthedevsout\Product\Admin
 * @author Carlos Artur Matos
 * 
 */
namespace Wooletthedevsout\Product\Admin;

class Tabs
{
	/**
	 * Tab name as shown in the backend
	 * 
	 * @var string
	 */
	public $tab;
	/**
	 * Slug for the new tab
	 * 
	 * @var string
	 */
	public $slug;
	/**
	 * Unique ID for the new tab
	 * 
	 * @var string
	 */
	public $tab_id;
	/**
	 * Array containing data for adding panel fields
	 * in the newly added tab
	 * 
	 * @var array
	 */
	public $forms;

	/**
	 * Class constructor
	 * 
	 * @param 	$tab 	string 	Name or label of the new tab
	 * @param 	$forms  array 	Data for adding the fields
	 * @since 1.0.0
	 * 
	 * @return void()
	 */
	public function __construct(string $tab, array $forms) 
	{
		$this->tab = $tab;
		$this->slug = sanitize_title($this->tab);
		$this->tab_id = $this->slug . '_product_data';

		$this->forms = $forms;

		add_filter('woocommerce_product_data_tabs', [$this, 'registerTab']);
	}

	/**
	 * Registers the new tab.
	 * 
	 * @param 	$tabs 	array 	All tabs on WC's product edit page.
	 * @since 1.0.0
	 * 
	 * @return 	$tabs
	 */
	public function registerTab($tabs)
	{

		$tabs[$this->slug] = [
			'label' => $this->tab,
			'target' => $this->tab_id
		];

		return $tabs;
	}

	/**
	 * Gets a new Panels() instance and returns its object. 
	 * 
	 * @since 1.0.0
	 * @return 	$panel 	object 	Instance of the class Panels()
	 * 
	 */
	public function getPanel()
	{
		$panel = new Panels($this->tab, $this->tab_id, $this->forms);

		return $panel;
	}
}
