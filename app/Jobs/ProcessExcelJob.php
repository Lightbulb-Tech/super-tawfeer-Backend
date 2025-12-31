<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProcessExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $file,
        public $mainCategoryId,
        public $subCategoryId,
        public $brandId,
    ) {}


    /**
     * Execute the job.
     */
    public function handle()
    {
        $fullPath = storage_path('app/' . $this->file);

        Excel::queueImport(
            new ProductsImport($this->mainCategoryId, $this->subCategoryId, $this->brandId), $fullPath
        );
    }
}
