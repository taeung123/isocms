<?php

use Spatie\Image\Image;

class ImageStyle extends dbBasic
{
	protected static $instance = null;

	protected $image;

	protected $uri;

	protected $styles = [];

	protected $effects = [
		'crop' => 'handleCrop',
		'resize' => 'handleResize',
		'scale_and_crop' => 'handleScaleAndCrop',
		'scale' => 'handleScale',
		'crop' => 'handleCrop',
		'rotate' => 'handleRotate',
		'watermark' => 'handleWatermark'
	];

	protected function __construct()
	{
		$this->pkey = 'id';
		$this->tbl = DB_PREFIX . 'image_style';
	}

	public static function getInstance()
	{
		if (is_null(static::$instance)) {
			require_once DIR_INCLUDES . '/spatie/image/vendor/autoload.php';
			static::$instance = new static();
		}

		return static::$instance;
	}

	public function render($uri = '', $style = '')
	{
		$this->uri = $uri;
		$this->image = Image::load($uri)->optimize();

		if (empty($this->styles[$style])) {
			$result = $this->getByCond("name = '$style'");

			// Nếu không có style return về ảnh gốc
			if (empty($result)) {
				return $uri;
			}

			$this->styles[$result['name']] = json_decode($result['effects'], true);
		}

		$effects = $this->styles[$style];

		$optimize = !empty($effects['optimize'])
			? $effects['optimize'] : false;
		unset($effects['optimize']);

		foreach ($effects as $effect => $params) {
		}

		if (!empty($optimize)) {
			$this->handleOptimize();
		}
	}

	public function createOrUpdateStyle($name, $effects) {}

	public function handleCrop($params = []) {}

	public function handleRotate($params = []) {}

	public function handleOptimize()
	{
		$this->image->optimize();
	}

	public function returnImage()
	{
		$imageType = mime_content_type($this->uri);
		header("Content-Type: $imageType");

		try {
			ob_start();
			$this->image->save('php://output');
			$image = ob_get_clean();
		} catch (\InvalidArgumentException $_) {
		}

		if (!empty($image)) {
			echo $image;
		}
	}
}
