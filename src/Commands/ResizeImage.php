<?php

namespace Jeremytubbs\LaravelResizer\Commands;

use App\Jobs\Job;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jeremytubbs\Resizer\ResizeFactory;

class ResizeImage extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

    protected $image;
    protected $filename;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($image, $filename = null)
    {
        $this->image = $image;
        $this->filename = $filename;
        $this->resizer = ResizeFactory::create([
            'path' => config('resizer.image_path'),
            'driver' => config('resizer.image_driver'),
            'format' => config('resizer.image_format'),
            'sizes' => config('resizer.image_sizes'),
            'image2x' => config('resizer.image_2x'),
        ]);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resizer->makeImages($this->image, $this->filename);
    }
}