<?php
class ModelPaymenttrustpay extends Model {

        public function getMethod($address, $total) {
                $this->load->language('payment/trustpay');
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('trustpay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

                if ($this->config->get('trustpay_total') > 0 && $this->config->get('trustpay_total') > $total) {
                        $status = false;
                } elseif (!$this->config->get('trustpay_geo_zone_id')) {
                        $status = true;
                } elseif ($query->num_rows) {
                        $status = true;
                } else {
                        $status = false;
                }
                $queryiso = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$address['country_id']."'");
                $method_data = array();
                $countryiso='';
                if ($queryiso->num_rows >0){
                        foreach ($queryiso->rows as $result) {
                                $countryiso=$result['iso_code_2'];
                        }
                        $url='https://my.trustpay.biz/PricePointProcessor/GetMethods?application='.$this->config->get('trustpay_vendor_id').'&country='.$countryiso;
                        $response = file_get_contents($url);
                        if ($status) {
                        $method_data = array(
                                'code'       => 'trustpay',
                                'title'      => $response,
                                'terms'      => '',
                                'sort_order' => $this->config->get('trustpay_sort_order')
                        );
                } else {
                        $response = file_get_contents('https://my.trustpay.biz/PricePointProcessor/GetMethods?application='.$this->config->get('trustpay_vendor_id'));
                        if ($status) {
                        $method_data = array(
                                'code'       => 'trustpay',
                                'title'      => $response,
                                'terms'      => '',
                                'sort_order' => $this->config->get('trustpay_sort_order')
                                );

                        }
                }



        return $method_data;
        }
        }


}
