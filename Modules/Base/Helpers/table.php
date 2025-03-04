<?php

if (!function_exists('table_checkbox')) {
    /**
     * @param int $id
     * @return string
     * @throws Throwable
     */
    function table_checkbox($id): string
    {
        return view('base::table.partials.checkbox', compact('id'))->render();
    }
}

if (!function_exists('table_actions')) {
    /**
     * @param string $edit
     * @param string $delete
     * @param \Modules\Base\Models\BaseModel $item
     * @param string $extra
     * @return string
     * @throws Throwable
     */
    function table_actions($edit, $delete, $item, $extra = null): string
    {
	    
        return view('base::table.partials.actions', compact('edit', 'delete', 'item', 'extra'))->render();
    }
}
