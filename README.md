Laravel Resizer
==

Artisan command to resize and create high-resolution images for use with picturefill / scrset.
This package utilizes my image resizer package: https://github.com/jeremytubbs/resizer

### Usage
Artisan command to queue image resizing:
```sh
php artisan resize:image
```

The artisan command accepts an image argument and an optional rename, source_path and destinataion argument. If no image argument is provided you will recieve a prompt to enter an image name. The `--source_path` and `--destiination` arguments default to the `public/images` directory. The `--destination` path appends to the `image_path` set in your `config\resizer.php` to create a directory structure for your resized images.

```sh
php artisan resize:image KISS.jpg --rename=keep-it-simple --source_path=resources/assets --destinataion=posts/kiss
```

The artisan command is queued and will use the `default` queue driver set in the `queue.php` config file.

If you would like to use the `ResizeImage` command inside a controller add the trait and dispatch the command:

```php
use Jeremytubbs\LaravelResizer\Commands\ResizeImage;

class MyController extends Controller
{
    use \Illuminate\Foundation\Bus\DispatchesJobs;

	public function resizeImage($image_path, $destination_path = null, $rename = null) {
		$command = new ResizeImage($image_path, $destination_path, $rename);
		$this->dispatch($command);
	}
}
```

### Setup
Add service provider to `app/config`:

```php
Jeremytubbs\LaravelResizer\ResizerServiceProvider::class,
````

Publish the `resizer.php` config file:
```sh
php artisan vendor:publish
```
