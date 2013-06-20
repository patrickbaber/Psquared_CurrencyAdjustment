<?php
class Psquared_CurrencyAdjustment_Model_Directory_Currency_Import_Webservicex extends Mage_Directory_Model_Currency_Import_Webservicex
{
	protected function _getAdjustmentArray() {
		$adjustments = Mage::getStoreConfig('currency/currency_adjustment/adjustment_values');
		$adjustmentLines = explode("\n", $adjustments);
		if (count($adjustmentLines) > 0) {
			$adjustmentArray = array();
			foreach ($adjustmentLines as $line) {
				$rows = explode(';', $line);
				$currency = trim($rows[0]);
				$factor = trim($rows[1]);

				if (!empty($currency) && !empty($factor)) {
					$adjustmentArray[$currency] = $factor;
				}
			}
			return $adjustmentArray;
		} else {
			return false;
		}

	}

	protected function _convert($currencyFrom, $currencyTo, $retry=0)
	{
		$number = parent::_convert($currencyFrom, $currencyTo, $retry);

		//currency adjustment
		if (Mage::getStoreConfig('currency/currency_adjustment/enable_adjustment') == 1) {
			$adjustments = $this->_getAdjustmentArray();
			if (array_key_exists($currencyTo, $adjustments)) {
				$number *= $adjustments[$currencyTo];
			}
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
		