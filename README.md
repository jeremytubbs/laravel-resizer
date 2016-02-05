Laravel Resizer
==

Artisan command to resize and create high-resolution images for use with picturefill / scrset.
This package utilizes my image resizer package: https://github.com/jeremytubbs/resizer

### Usage
Artisan command to queue image resizing:
```sh
php artisan resize:image
```

The artisan command accepts an image argument and an optional filename and source_path. If no image argument is provided you will recieve a prompt to enter an image name. The image path defaults to the public/images directory.

```sh
php artisan resize:image KISS.jpg --filename=keep-it-simple --source_path=posts
```

The artisan command is queued and will use the `default` queue driver set in the `queue.php` config file.

If you would like to use the `ResizeImage` command inside a controller add the trait and dispatch the command:

```php
use Jeremytubbs\LaravelResizer\Commands\ResizeImages;

class MyController extends Controller
{
    use \Illuminate\Foundation\Bus\DispatchesJobs;

	public function resizeImage($image, $filename = null) {
		$command = new ResizeImage($image, $filename);
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
