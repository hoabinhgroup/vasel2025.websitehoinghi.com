<?php

namespace Modules\Theme;

class ThemeManager
{
    /**
     * @var array
     */
    protected $themes = [];

    /**
     * Construct the class
     */
    public function __construct()
    {
        $this->registerTheme(self::getAllThemes());
    }

    /**
     * @return array
     * @author Tuan Louis
     */
    public function getAllThemes()
    {
        $themes = [];
        $themePath = public_path(config('theme.themeDir'));
       

        foreach (scan_folder($themePath) as $folder) {
          if($folder !== '.DS_Store'){
            $theme = get_file_json($themePath . DIRECTORY_SEPARATOR . $folder . '/theme.json');
            if (!empty($theme)) {
                $themes[$folder] = $theme;
            }
            }
        }
        return $themes;
    }

    /**
     * @param $theme
     * @return void
     * @author Tuan louis
     */
    public function registerTheme($theme)
    {
        if (!is_array($theme)) {
            $theme = [$theme];
        }
        $this->themes = array_merge_recursive($this->themes, $theme);
    }

    /**
     * @return array
     * @author Tuan Louis
     */
    public function getThemes()
    {
        return $this->themes;
    }
    

}
