<?php

namespace App\Traits;

trait HasTasks{

    /**
     * If task title is null or empty
     *
     * @return bool
    */
    public function titleIsEmpty()
    {
        return empty($this->title) && is_null($this->title);
    }
}
