<?php

namespace App\Observers;

abstract class AbstractObserver
{

    abstract public function created($model);

    abstract public function updated($model);

    abstract public function deleted($model);
}
