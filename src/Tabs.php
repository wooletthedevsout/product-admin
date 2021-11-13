<?php 

namespace Wooletthedevsout\Product\Admin;

class Tabs
{
	public $tab;

	public $slug;

	public $tab_id;

	public $forms;

	public function __construct(string $tab, array $forms) 
	{
		$this->tab = $tab;
		$this->slug = sanitize_title($this->tab);
		$this->tab_id = $this->slug . '_product_data';

		$this->forms = $forms;

		add_filter('woocommerce_product_data_tabs', [$this, 'registerTab']);
	}

	public function registerTab($tabs)
	{

		$tabs[$this->slug] = [
			'label' => $this->tab,
			'target' => $this->tab_id
		];

		return $tabs;
	}

	public function getPanel()
	{
		$panel = new Panels($this->tab, $this->tab_id, $this->forms);

		return $panel;
	}
}