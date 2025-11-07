<?php
namespace PrestaShop\Module\Weather\Models;

/**
 * Base model class
 */
class BaseModel {


    // =================
    // === Variables ===
    // =================

    /* @var int city id */
    private $id;


    // ===============
    // === Getters ===
    // ===============

    public function getId() {
        return $this->id;
    }


    // ===================
    // === Constructor ===
    // ===================

    public function __construct($id = 0) {
        $this->id = $id;
    }
}
