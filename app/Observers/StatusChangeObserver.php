<?php

namespace App\Observers;

use App\Services\StatusChangeNotifier;
use Illuminate\Database\Eloquent\Model;

class StatusChangeObserver
{
    public function updated(Model $model): void
    {
        if (! $model->wasChanged('status')) {
            return;
        }

        if (! method_exists($model, 'toStatusChangeData')) {
            return;
        }

        StatusChangeNotifier::send(
            $model->toStatusChangeData((string) $model->getOriginal('status'))
        );
    }
}
