<?php
    /**
     * Returns id_address for a given id_supplier
     * @since 1.5.0
     * @param int $id_supplier
     * @return int $id_address
     */
    public static function getAddressIdBySupplierId($id_supplier)
    {
        $query = new DbQuery();
        $query->select('id_address');
        $query->from('address');
        $query->where('id_supplier = '.(int)$id_supplier);
        $query->where('deleted = 0');
        $query->where('id_customer = 0');
        $query->where('id_manufacturer = 0');
        $query->where('id_warehouse = 0');
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
    }

    public static function aliasExist($alias, $id_address, $id_customer)
    {
        $query = new DbQuery();
        $query->select('count(*)');
        $query->from('address');
        $query->where('alias = \''.pSQL($alias).'\'');
        $query->where('id_address != '.(int)$id_address);
        $query->where('id_customer = '.(int)$id_customer);
        $query->where('deleted = 0');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
    }

    public function getFieldsRequiredDB()
    {
        $this->cacheFieldsRequiredDatabase(false);
        if (isset(self::$fieldsRequiredDatabase['Address'])) {
            return self::$fieldsRequiredDatabase['Address'];
        }
        return array();
    }


        public function duplicate()
    {
        if (!Validate::isLoadedObject($this)) {
            return false;
        }

        $cart = new Cart($this->id);
        $cart->id = null;
        $cart->id_shop = $this->id_shop;
        $cart->id_shop_group = $this->id_shop_group;

        if (!Customer::customerHasAddress((int)$cart->id_customer, (int)$cart->id_address_delivery)) {
            $cart->id_address_delivery = (int)Address::getFirstCustomerAddressId((int)$cart->id_customer);
        }

        if (!Customer::customerHasAddress((int)$cart->id_customer, (int)$cart->id_address_invoice)) {
            $cart->id_address_invoice = (int)Address::getFirstCustomerAddressId((int)$cart->id_customer);
        }

        if ($cart->id_customer) {
            $cart->secure_key = Cart::$_customer->secure_key;
        }

        $cart->add();

        if (!Validate::isLoadedObject($cart)) {
            return false;
        }