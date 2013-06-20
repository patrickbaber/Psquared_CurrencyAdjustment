<?php

class Psquared_CurrencyAdjustment_Model_RoundingMethods
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=> Mage::helper('currencyadjustment')->__('round')),
            array('value' => 2, 'label'=> Mage::helper('currencyadjustment')->__('ceil')),
            array('value' => 3, 'label'=> Mage::helper('currencyadjustment')->__('floor')),
        );
    }
}