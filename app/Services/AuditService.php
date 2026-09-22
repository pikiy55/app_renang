<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    /**
     * Catat aksi admin ke audit log.
     *
     * @param User   $actor   Admin yang melakukan aksi
     * @param string $action  Nama aksi: edit, delete, import, export
     * @param Model  $model   Model yang diubah
     * @param array  $before  Data sebelum perubahan
     * @param array  $after   Data sesudah perubahan
     */
    public function log(User $actor, string $action, Model $model, array $before = [], array $after = []): AuditLog
    {
        return AuditLog::create([
            'user_id'    => $actor->id,
            'action'     => $action,
            'model_type' => get_class($model),
            'model_id'   => $model->getKey(),
            'before'     => $before,
            'after'      => $after,
        ]);
    }
}
