<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Country;
use App\Models\Banha\ReasonCancellation;
use App\Repositories\MainRepository;

class ReasonCancellationRepository extends MainRepository
{
    public function __construct(ReasonCancellation $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('reason_cancellations.id', 'reason_cancellation_translations.title')
            ->join('reason_cancellation_translations', function ($join) {
                $join->on('reason_cancellations.id', '=', 'reason_cancellation_translations.reason_id')
                    ->where('reason_cancellation_translations.locale', app()->getLocale());
            })->orderBy('reason_cancellations.created_at', 'desc');
    }
}
