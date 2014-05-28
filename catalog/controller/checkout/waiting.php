<?php
class ControllerCheckoutWaiting extends Controller { 
	public function index() { 

	
		$this->load->language('checkout/waiting');
			
		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['breadcrumbs'] = array(); 
		
      	$data['breadcrumbs'][] = array(
        	'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
      	); 
		
      	$data['breadcrumbs'][] = array(
        	'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
      	);
				
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);	
					
      	$data['breadcrumbs'][] = array(
        	'text' => $this->language->get('text_failure'),
			'href' => $this->url->link('checkout/failure')
      	);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));
		$data['button_continue'] = $this->language->get('button_continue');
		$data['continue'] = $this->url->link('common/home');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['order'] = $this->session->data['order_id'];
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
                                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/waiting.tpl', $data));
                        } else {
                                $this->response->setOutput($this->load->view('default/template/common/waiting.tpl', $data));
                        }
		}
  	}
}
