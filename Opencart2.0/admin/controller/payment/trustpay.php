<?php 
class ControllerPaymenttrustpay extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->load->language('payment/trustpay');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('trustpay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
				
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_vendor_id'] = $this->language->get('entry_vendor_id');
		$data['entry_notification_url'] = $this->language->get('entry_notification_url');
		$data['entry_shared_secret'] = $this->language->get('entry_shared_secret');		
		$data['entry_total'] = $this->language->get('entry_total');	
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['help_total'] = $this->language->get('help_total');
		$data['help_vendor_id'] = $this->language->get('help_vendor_id');
		$data['help_notification_url'] = $this->language->get('help_notification_url');
		$data['help_shared_secret'] = $this->language->get('help_shared_secret');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/trustpay', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['action'] = $this->url->link('payment/trustpay', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');	
		
		if (isset($this->request->post['trustpay_vendor_id'])) {
			$data['trustpay_vendor_id'] = $this->request->post['trustpay_vendor_id'];
		} else {
			$data['trustpay_vendor_id'] = $this->config->get('trustpay_vendor_id'); 
		}
		if (isset($this->request->post['trustpay_notification_url'])) {
			$data['trustpay_notification_url'] = $this->request->post['trustpay_notification_url'];
		} else {
			$data['trustpay_notification_url'] = $this->config->get('trustpay_notification_url'); 
		}
		if (isset($this->request->post['trustpay_shared_secret'])) {
			$data['trustpay_shared_secret'] = $this->request->post['trustpay_shared_secret'];
		} else {
			$data['trustpay_shared_secret'] = $this->config->get('trustpay_shared_secret'); 
		}
		
		if (isset($this->request->post['trustpay_total'])) {
			$data['trustpay_total'] = $this->request->post['trustpay_total'];
		} else {
			$data['trustpay_total'] = $this->config->get('trustpay_total'); 
		}
				
		if (isset($this->request->post['trustpay_order_status_id'])) {
			$data['trustpay_order_status_id'] = $this->request->post['trustpay_order_status_id'];
		} else {
			$data['trustpay_order_status_id'] = $this->config->get('trustpay_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['trustpay_geo_zone_id'])) {
			$data['trustpay_geo_zone_id'] = $this->request->post['trustpay_geo_zone_id'];
		} else {
			$data['trustpay_geo_zone_id'] = $this->config->get('trustpay_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');						
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['trustpay_status'])) {
			$data['trustpay_status'] = $this->request->post['trustpay_status'];
		} else {
			$data['trustpay_status'] = $this->config->get('trustpay_status');
		}
		
		if (isset($this->request->post['trustpay_sort_order'])) {
			$data['trustpay_sort_order'] = $this->request->post['trustpay_sort_order'];
		} else {
			$data['trustpay_sort_order'] = $this->config->get('trustpay_sort_order');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['menu'] = $this->load->controller('common/menu');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('payment/trustpay.tpl', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/trustpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
				
		return !$this->error;
	}
}
