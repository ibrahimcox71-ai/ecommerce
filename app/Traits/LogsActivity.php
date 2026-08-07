<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            $model->logActivityEvent('created', static::activityDescription('created', $model));
        });

        static::updated(function (Model $model) {
            if ($model->isClean('deleted_at')) {
                $model->logActivityEvent('updated', static::activityDescription('updated', $model), $model->getChanges());
            }
        });

        static::deleted(function (Model $model) {
            if ($model->isForceDeleting()) {
                if (property_exists($model, 'logForceDelete') && $model->logForceDelete) {
                    $model->logActivityEvent('forceDeleted', static::activityDescription('forceDeleted', $model));
                }
            } else {
                $model->logActivityEvent('trashed', static::activityDescription('trashed', $model));
            }
        });

        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(static::class))) {
            static::restored(function (Model $model) {
                $model->logActivityEvent('restored', static::activityDescription('restored', $model));
            });
        }
    }

    protected static function activityLogName(): string
    {
        return defined(static::class . '::ACTIVITY_LOG') ? static::ACTIVITY_LOG : static::getModelName();
    }

    protected static function activityDescription(string $action, Model $model): string
    {
        $name = method_exists($model, 'activityLogTitle') ? $model->activityLogTitle() : ($model->name ?? $model->id);

        return match ($action) {
            'created' => static::activityLogName() . " '{$name}' was created",
            'updated' => static::activityLogName() . " '{$name}' was updated",
            'trashed' => static::activityLogName() . " '{$name}' was trashed",
            'restored' => static::activityLogName() . " '{$name}' was restored",
            'forceDeleted' => static::activityLogName() . " '{$name}' was permanently deleted",
            default => static::activityLogName() . " '{$name}' was {$action}",
        };
    }

    protected function logActivityEvent(string $action, string $description, ?array $properties = null): void
    {
        $causerType = null;
        $causerId = null;

        if (auth()->guard('admin')->check()) {
            $causerType = 'App\Models\Admin';
            $causerId = auth()->guard('admin')->id();
        } elseif (auth()->check()) {
            $causerType = get_class(auth()->user());
            $causerId = auth()->id();
        }

        $data = [
            'log_name' => static::activityLogName(),
            'description' => $description,
            'subject_type' => static::class,
            'subject_id' => $this->id ?? $this->getKey(),
            'causer_type' => $causerType,
            'causer_id' => $causerId,
        ];

        if ($properties !== null) {
            $data['properties'] = $properties;
        }

        ActivityLog::create($data);
    }

    protected static function getModelName(): string
    {
        $parts = explode('\\', static::class);
        return strtolower(array_pop($parts));
    }
}
