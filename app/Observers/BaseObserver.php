<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseObserver
{
    protected function logActivity(Model $model, string $action): void
    {
        $user = auth()->user();

        activity()
            ->performedOn($model)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $model->getAttributes(),
                'original' => $model->getOriginal(),
            ])
            ->log($action);
    }

    protected function logError(\Throwable $e, Model $model, string $action): void
    {
        Log::error("Observer {$action} failed for " . get_class($model) . ": {$e->getMessage()}", [
            'model_id' => $model->id ?? null,
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
