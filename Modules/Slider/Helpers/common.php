<?php
use Modules\Slider\Repositories\SliderInterface;

if (!function_exists("get_slider")) {
  /**
   * @param array $condition
   * @return mixed
   *
   */
  function get_slider($key)
  {
    $slider = app(SliderInterface::class)->getFirstBy([
      "key" => $key,
      "status" => 1,
    ]);

    if (empty($slider)) {
      return null;
    }

    return $slider->sliderItems;
  }
}

