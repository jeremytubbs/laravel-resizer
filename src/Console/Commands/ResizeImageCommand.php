<?php

namespace Jeremytubbs\LaravelResizer\Console\Commands;

use Illuminate\Console\Command;
use Jeremytubbs\LaravelResizer\Commands\ResizeImage;

class ResizeImageCommand extends Command
{
    use \Illuminate\Foundation\Bus\DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resize:image
        {image? : Image that will be tiled.}
        {--destination=null : Optional destination directory path.}
        {--source_path=null : Optional image source path, default is public/images.}
        {--rename=null : Optional filename for output.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resize Image.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $destination_path = $this->option('destination') == 'null' ? null : $this->option('destination');
        $source_path = $this->option('source_path') == 'null' ? public_path('images') : $this->option('source_path');
        $rename = $this->option('rename') == 'null' ? null : $this->option('rename');
        $image_path = $source_path . '/' . $this->argument('image');

        // check if path is valid
        if (\File::exists($image_path)) {
            $image = $this->argument('image');
        } else {
            $this->error('Image not found!');
            $this->error($image_path);
            $image_path = null;
        }

        // loop until path is valid
        while (! $image_path) {
            $temp_image = $this->ask('Enter an image name?');
            $temp_path = $source_path . '/' . $temp_image;
            if (! \File::exists($temp_path)) {
                $this->error('Image not found!');
                $this->error($temp_path);
            } else {
                $image = $temp_image;
                $image_path = $temp_path;
            }
        }

        $command = new ResizeImage($image_path, $destination_path, $rename);
        $this->dispatch($command);
    }
}
