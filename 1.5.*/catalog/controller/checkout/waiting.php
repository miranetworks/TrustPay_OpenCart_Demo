<?php
class ControllerCheckoutWaiting extends Controller { 
	public function index() { 

	
		$this->load->language('checkout/waiting');
			
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['breadcrumbs'] = array(); 
		
      	$this->data['breadcrumbs'][] = array(
        	'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
      	); 
		
      	$this->data['breadcrumbs'][] = array(
        	'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
      	);
				
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);	
					
      	$this->data['breadcrumbs'][] = array(
        	'text' => $this->language->get('text_failure'),
			'href' => $this->url->link('checkout/failure')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['continue'] = $this->url->link('common/home');
		$this->data['order'] = $this->session->data['order_id'];
		error_log('Waiting:'.$this->session->data['waiting']);
		$order_id=$this->session->data['order_id'];
		error_log('Order_id:'.$order_id);
		$this->load->model('checkout/order');
                $order_info = $this->model_checkout_order->getOrder($order_id);
                error_log('Order status 1:'.$order_info['order_status_id']);
		if ($order_info['order_status_id']==$this->config->get('trustpay_order_status_id')) {
			$this->response->redirect($this->url->link('checkout/success'));
		} else if ($order_info['order_status_id']==10) {
			$this->response->redirect($this->url->link('checkout/failure'));
		} else {
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/waiting.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/common/waiting.tpl';
                } else {
                        $this->template = 'default/template/common/waiting.tpl';
                }

                $this->children = array(
                        'common/column_left',
                        'common/column_right',
                        'common/content_top',
                        'common/content_bottom',
                        'common/footer',
                        'common/header'
                );

                $this->response->setOutput($this->render());
		}
  	}
}
