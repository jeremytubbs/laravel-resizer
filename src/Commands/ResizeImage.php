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
    protected $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($image, $filename = null, $config = null)
    {
        $this->image = $image;
        $this->filename = $filename;
        $this->setResizer($config);
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

    public function setResizer($config)
    {
        $this->resizer = ResizeFactory::create([
            'path'    => isset($config['image_path']) ? $config['image_path'] : config('resizer.image_path'),
            'driver'  => isset($config['image_driver']) ? $config['image_driver'] : config('resizer.image_driver'),
            'format'  => isset($config['image_format']) ? $config['image_format'] : config('resizer.image_format'),
            'sizes'   => isset($config['image_sizes']) ? $config['image_sizes'] : config('resizer.image_sizes'),
            'image2x' => isset($config['image_2x']) ? $config['image_2x'] : config('resizer.image_2x'),
        ]);
    }
}