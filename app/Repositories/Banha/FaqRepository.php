<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Faq;
use App\Repositories\MainRepository;

class FaqRepository extends MainRepository
{
    public function __construct(Faq $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('faqs.id', 'faq_translations.question', 'faq_translations.answer')
            ->join('faq_translations', function ($join) {
                $join->on('faqs.id', '=', 'faq_translations.faq_id')
                    ->where('faq_translations.locale', app()->getLocale());
            })
            ->orderBy('faqs.created_at', 'desc');
    }


}
