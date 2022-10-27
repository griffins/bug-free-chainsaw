<?php

if (!function_exists('paste_icon')) {
    /**
     * @return boolean
     */
    function paste_icon($icon)
    {
        return file_get_contents(resource_path('icons/') . "$icon.svg");
    }
}


if (!function_exists('sidebar_active')) {

    /**
     * Generate Active Classes if Route matches the current route
     *
     * @param string|array $routes
     * @return string
     */
    function sidebar_active($route)
    {
        $classes = '';

        $active_classes = ' active';


        $current_route = \Route::currentRouteName();

        //Allow checking of route arrays as well

        if (is_array($route)) {
            //Check if matches any of the provided route
            foreach ($route as $route_name) {
                if ($route_name == $current_route) {
                    $classes .= $active_classes;
                }
            }
        } elseif ($route == $current_route) {
            $classes .= $active_classes;
        }

        return $classes;
    }
}

if (!function_exists('sidebar_list_item')) {

    /**
     * Generate Active Classes if Route matches the current route
     *
     * @param string|array $routes
     * @return string
     */
    function sidebar_list_item($route, $label, $icon)
    {
        $active = sidebar_active($route);
        $route = route($route);
        $icon = paste_icon($icon);
        return <<<DOC
               <li class="nav-item $active">
                            <a class="nav-link" href="$route">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                 $icon
                              </span>
                            <span class="nav-link-title">
                                $label
                        </span>
                        </a>
</li>
DOC;
    }
}

if (!function_exists('sidebar_list_drop_down')) {

    /**
     * Generate Active Classes if Route matches the current route
     *
     * @param string|array $routes
     * @return string
     */
    function sidebar_list_drop_down($label, $icon, $items)
    {
        $item_routes = collect($items)->map(function ($item) {
            list(, $link) = $item;
            return $link;
        })->toArray();
        $active = sidebar_active($item_routes);
        $icon = paste_icon($icon);
        $items = collect($items)->map(function ($item) {
            list($title, $link, $icon) = $item;
            $link = route($link);
            $icon = paste_icon($icon);
            return <<<DOC
<a class="dropdown-item" href="$link">
    <span class="nav-link-icon d-md-none d-lg-inline-block">
        $icon
    </span>
    $title
</a>      
DOC;
        })->reduce(function ($acc, $item) {
            return sprintf("%s%s\n", $acc, $item);
        });
        return <<<DOC
               <li class="nav-item $active dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                $icon
                                    </span>
                                    <span class="nav-link-title">
                                      $label
                                    </span>
                            </a>
                            <div class="dropdown-menu">
                               $items                       
                            </div>
                        </li>
DOC;
    }
}


if (!function_exists('odd_format')) {

    /**
     * @param int $amount
     * @return string
     */
    function odd_format($amount)
    {
        return sprintf('%s', number_format($amount, 2));
    }
}
