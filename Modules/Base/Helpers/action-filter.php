<?php 
use Illuminate\Support\Arr;
	
if (!function_exists('add_filter')) {
    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     * @param int $arguments
     * @author Tuan Louis
     */
    function add_filter($hook, $callback, $priority = 20, $arguments = 1)
    {
        Filter::addListener($hook, $callback, $priority, $arguments);
    }
}	

if (!function_exists('remove_filter')) {
    /**
     * @param $hook
     * @author Tuan Louis
     */
    function remove_filter($hook)
    {
        Filter::removeListener($hook);
    }
}


if (!function_exists('apply_filters')) {
    /**
     * @return mixed
     * @author Tuan Louis
     */
    function apply_filters()
    {
        $args = func_get_args();
        return Filter::fire(array_shift($args), $args);
    }
}
	
if (!function_exists('add_action')) {
    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     * @param int $arguments
     * @author Tuan Louis
     */
    function add_action($hook, $callback, $priority = 20, $arguments = 1)
    {
        Action::addListener($hook, $callback, $priority, $arguments);
    }
}


if (!function_exists('do_action')) {
    /**
     * @author Tuan Louis
     */
    function do_action()
    {
        $args = func_get_args();
        
        Action::fire(array_shift($args), $args);
    }
}	


if (!function_exists('get_hooks')) {
    /**
     * @param string|null $name
     * @param bool $isFilter
     * @return array
     */
    function get_hooks(?string $name = null, $isFilter = true): array
    {
        if ($isFilter == true) {
            $listeners = Filter::getListeners();
        } else {
            $listeners = Action::getListeners();
        }

        if (empty($name)) {
            return $listeners;
        }
        return Arr::get($listeners, $name, []);
    }
}
