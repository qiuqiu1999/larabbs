<?php
namespace App\Models;

trait Common{
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }
}