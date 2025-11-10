<?php
namespace App\Models;

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


    // ===============
    // === Setters ===
    // ===============

    public function setId($id) {
        $this->id = $id;
    }


    // ===================
    // === Constructor ===
    // ===================

    public function __construct($id = 0) {
        $this->id = $id;
    }
}
