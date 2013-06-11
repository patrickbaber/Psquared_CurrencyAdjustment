<?php
class Psquared_CurrencyAdjustment_Model_Directory_Currency_Import_Webservicex extends Mage_Directory_Model_Currency_Import_Webservicex
{
	protected function _numberFormat($number)
	{
		//no modification on the base currency
		if ($number == 1) {
			return $number;
		}

		//currency adjustment
		if (Mage::getStoreConfig('currency/currency_adjustment/enable_adjustment') == 1) {
			$adjustment = Mage::getStoreConfig('currency/currency_adjustment/adjustment_value');
			$number = $number * $adjustment;
		}

		//currency rounding
		if (Mage::getStoreConfig('currency/currency_adjustment/enable_rounding') == 1) {
			$precision = (int) Mage::getStoreConfig('currency/currency_adjustment/number_digits');

			//rounding method
			switch (Mage::getStoreConfig('currency/currency_adjustment/rounding_method')) {
				case 1:
					$number = round($number, $precision);
					break;
				case 2:
					$number = ceil($number);
					break;
				default:
					$number = floor($number);
			}
		}
		return $number;
	}
}
		