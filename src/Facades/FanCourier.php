<?php
namespace SeniorProgramming\FanCourier\Facades;

use Illuminate\Support\Facades\Facade;

class FanCourier extends Facade  {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'fancourier'; }
}