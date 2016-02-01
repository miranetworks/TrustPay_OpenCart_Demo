<?php
include_once ('./oauth/library/OAuthRequest.php');
class ControllerPaymenttrustpay extends Controller {
	public function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$nonce=uniqid();
		$time=time();
		$this->load->model('checkout/order');
		$vendor_id = $this->config->get('trustpay_vendor_id');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$this->data['action'] = 'https://my.trustpay.biz/TrustPayWebClient/Transact';
		$this->data['vendor_id'] = $vendor_id;
		$this->data['currency'] = $order_info['currency_code'];
		$this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'],'', false);
		$this->data['countrycode'] = $order_info['payment_iso_code_2'];
		$this->data['txid'] = $this->session->data['order_id'];
		$this->data['appuser'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
		$this->data['success'] = $this->url->link('payment/trustpay/waiting?transaction_id='.$this->session->data['order_id']);
                $this->data['fail'] = $this->url->link('payment/trustpay/fail');
		$this->data['message'] = $this->config->get('config_title').' Checkout Transaction';
		$this->data['firstname'] = $order_info['payment_firstname'];
		$this->data['surname'] = $order_info['payment_lastname'];
		$this->data['address'] = $order_info['payment_address_1'];
		$this->data['city'] = $order_info['payment_city'];
		$this->data['province'] = $order_info['payment_zone'];
		$this->data['postcode'] = $order_info['payment_postcode'];
		$this->data['country'] = $order_info['payment_country'];
		$this->data['email'] = $order_info['email'];
		$this->data['phone'] = $order_info['telephone'];
		$this->data['oauth_consumer_key'] = $vendor_id;
		$this->data['oauth_nonce'] = $nonce;
		$this->data['oauth_signature_method'] = 'HMAC-SHA1';
		$this->data['oauth_timestamp'] = $time;
		$this->data['oauth_version'] = '1.0';

		$url='https://my.trustpay.biz/TrustPayWebClient/Transact';
		$params = 'address='.$order_info['payment_address_1'];
		$params = $params.'&amount='.$this->currency->format($order_info['total'], $order_info['currency_code'],'', false);
		$params = $params.'&appuser='.$order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
		$params = $params.'&city='.$order_info['payment_city'];
		$params = $params.'&country='.$order_info['payment_country'];
		$params = $params.'&countrycode='.$order_info['payment_iso_code_2'];
		$params = $params.'&currency='.$order_info['currency_code'];
		$params = $params.'&email='.$order_info['email'];
		$params = $params.'&fail='.$this->url->link('payment/trustpay/fail');
		$params = $params.'&firstname='.$order_info['payment_firstname'];
		$params = $params.'&istest='.'false';
		$params = $params.'&message='.$this->config->get('config_title').' Checkout Transaction';
		$params = $params.'&oauth_consumer_key='.$vendor_id;
		$params = $params.'&oauth_nonce='.$nonce;
		$params = $params.'&oauth_signature_method='.'HMAC-SHA1';
		$params = $params.'&oauth_timestamp='.$time;
		$params = $params.'&oauth_version='.'1.0';
		$params = $params.'&phone='.$order_info['telephone'];
		$params = $params.'&postcode='.$order_info['payment_postcode'];
		$params = $params.'&province='.$order_info['payment_zone'];
		$params = $params.'&success='.$this->url->link('payment/trustpay/waiting?transaction_id='.$this->session->data['order_id']);
		$params = $params.'&surname='.$order_info['payment_lastname'];
		$params = $params.'&txid='.$this->session->data['order_id'];
		$params = $params.'&vendor_id='.$vendor_id;
		
		
		$shared_secret = $this->config->get('trustpay_shared_secret');
		$request = new OAuthRequest($url,'',$params);
		
		$oauth_signature = $request -> calculateSignature($shared_secret, '' , 'requestToken');
		$this->data['oauth_signature'] = $oauth_signature;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/trustpay.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/payment/trustpay.tpl';
                } else {
                        $this->template = 'default/template/payment/trustpay.tpl';
                }

                $this->render();
	}
	public function waiting(){
		$this->response->redirect($this->url->link('checkout/waiting&transaction_id='.$this->request->get['transaction_id']));	
	}
	public function fail(){
		$this->response->redirect($this->url->link('checkout/fail'));  
	}
	public function notification(){
	
	$amount=$this->request->get['amount'];
	$application=$this->request->get['application_id'];
	$consmsg=$this->request->get['consumermessage'];
	$curr=$this->request->get['currency'];
	$desc=$this->request->get['description'];
	$method=$this->request->get['method'];
	$status=$this->request->get['status'];
	$tptxid=$this->request->get['tp_transaction_id'];
	$txid=$this->request->get['transaction_id'];
	$txtime=$this->request->get['transaction_time'];
	$user=$this->request->get['user_id'];
	$consumer_key = $this->request->get['oauth_consumer_key'];
	$oanonce=$this->request->get['oauth_nonce'];
	$oamethod=$this->request->get['oauth_signature_method'];
	$oatime=$this->request->get['oauth_timestamp'];
	$oaver=$this->request->get['oauth_version'];

	$params='amount='.$amount;
	$params=$params.'&application_id='.$application;
	$params=$params.'&consumermessage='.$consmsg;
	$params=$params.'&currency='.$curr;
	$params=$params.'&description='.$desc;
	$params=$params.'&method='.$method;
	$params=$params.'&status='.$status;
	$params=$params.'&tp_transaction_id='.$tptxid;
	$params=$params.'&transaction_id='.$txid;
	$params=$params.'&transaction_time='.$txtime;
	$params=$params.'&user_id='.$user;
	$params=$params.'&oauth_consumer_key='.$consumer_key;
	$params=$params.'&oauth_nonce='.$oanonce;
	$params=$params.'&oauth_signature_method='.$oamethod;
	$params=$params.'&oauth_timestamp='.$oatime;
	$params=$params.'&oauth_version='.$oaver;
	$params=$params.'&route='.'payment/trustpay/notification';

	$shared_secret = $this->config->get('trustpay_shared_secret');
	$notificationurl = $this->config->get('trustpay_notification_url');
	$pos = strpos($notificationurl,'?');
	$url = substr($notificationurl,0,$pos);
	error_log("SECRET:".$shared_secret);
	error_log("POS:".$pos);
	error_log("NOTIFY:".$notificationurl);
	error_log("URL:".$url);
	error_log("PARAMS:".$params);
	$original_signature =$this->request->get['oauth_signature'];
	$request = new OAuthRequest($url,"GET",$params);
	print_r($request);
	$oauth_signature = $request -> calculateSignature($shared_secret, '' , 'requestToken');
	error_log("calculated:".urldecode($oauth_signature));
	error_log("incoming:".$original_signature);
	error_log('status:'.$this->request->get['status']);
			if (isset($this->request->get['transaction_id'])) {
                                $order_id = $this->request->get['transaction_id'];
                        } else {
                                $order_id = 0;
                        }
		if ($this->request->get['status'] == 'SUCCESS'){
			error_log('Processing success for order no :'.$order_id);
			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($order_id);	
			error_log('Order status 1:'.$order_info['order_status_id']);
			$this->model_checkout_order->confirm($order_id, $this->config->get('trustpay_order_status_id'));
			error_log('Order status 2:'.$order_info['order_status_id']);
			error_log('Processed success for order no :'.$order_id);
		
		} else {
			$this->load->model('checkout/order');
			$this->model_checkout_order->confirm($order_id,10);
			error_log('Processed failure for order no :'.$order_id);
		}
	}
	

}