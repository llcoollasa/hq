<?php

if ( ! function_exists('getCurrency'))
{
	function getCurrency($type='cur')
	{
		$CI =& get_instance(); 
		$cur = null;  
		$cur_list = $CI->config->config['cur_list'];
		if($CI->session->userdata('cur'))
		{ 
			$cur["cur"] = $CI->session->userdata('cur');
			$cur["cur_symbol"] = $cur_list[$cur["cur"]];
		}
		else
		{
			$default_cur = $CI->config->config['cur_default']; 
			 
			$CI->session->set_userdata('cur', $default_cur);
			$CI->session->set_userdata('cur_symbol', $cur_list[$default_cur]); 

			$cur["cur"] = $default_cur;;
			$cur["cur_symbol"] =$cur_list[$default_cur];
		}

		if($type=='symbol')
		{
			return $cur["cur_symbol"];
		}
		else
		{
			if($type=='')
			{
				return $cur;
			}
			else
			{
				return $cur['cur']; 
			} 
		} 
	} 
}



if ( ! function_exists('getCurrencyList'))
{
	function getCurrencyList()
	{ 
		$CI =& get_instance(); 
		$cur = getCurrency(); 
		$cur_list = $CI->config->config['cur_list']; 
		$options = "";

		foreach ($cur_list as $key=>$val) {

			if($cur == $key)
			{
				$options .= "<option value=\"$key\" selected=\"selected\">$key</option>";	
			}
			else
			{
				$options .= "<option value=\"$key\">$key</option>";
			}
		}
		return $options;
	}
}


if ( ! function_exists('changeCurrency'))
{
	function changeCurrency()
	{ 
		$CI =& get_instance();
		$cur = $CI->input->post('cur');
		$CI->session->set_userdata('cur', $cur);
	}
}
