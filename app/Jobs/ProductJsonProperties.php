<?php

namespace App\Jobs;

use Domain\Product\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductJsonProperties implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @return void
     */
    public function __construct(
        public Product $product
    )
    {
    }

    public function handle(): void
    {
        $properties = $this->product->properties->keyValues();

        $this->product->updateQuietly(['json_properties' => $properties]);
    }

    public function uniqueId()
    {
        return $this->product->id;
    }
}
