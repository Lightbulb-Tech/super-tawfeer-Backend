<?php

if (!function_exists('createBtn')) {
    function createBtn($route, $text = "", $color = 'success'): string
    {
        if (checkIfHasPermission(extractMainRouteSegment($route) . '-create')) {
            $fullText = __("buttons.add_button") . ' ' . $text;
            $routeUrl = $route;
            return '<button type="button" class="btn btn-' . $color . ' mb-2"
                        onclick="createButton(\'' . $routeUrl . '\', \'' . $fullText . '\')">
                        <i class="fa fa-plus-circle" style="padding-left: 5px;"></i> ' . $fullText . '
                    </button>';
        }
        return '';
    }
}

if (!function_exists('storeButton')) {
    function storeButton($route = "", $text = "", $color = 'success'): string
    {
        if (checkIfHasPermission(extractMainRouteSegment($route) . '-create')) {

            $fullText = ($text != "") ? $text : __("buttons.save");
            return '<button class="btn btn-' . $color . ' " type="submit">' . $fullText . '</button>';
        }
        return '';
    }
}
if (!function_exists('updateButton')) {
    function updateButton($route = "", $text = "", $color = 'success'): string
    {
        if (checkIfHasPermission(extractMainRouteSegment($route) . '-update')) {
            $fullText = ($text != "") ? $text : __("buttons.save");
            return '<button class="btn btn-' . $color . ' " type="submit">' . $fullText . '</button>';
        }
        return '';
    }
}
if (!function_exists('editBtn')) {
    function editBtn($route, $id, $text, $color = 'primary'): string
    {
        $routeUrl = route($route . '.edit', $id);
        if (checkIfHasPermission(extractMainRouteSegment($routeUrl) . '-update')) {
            $fullText = __("buttons.edit_button") . ' ' . $text;
            return '<button type="button" class="btn btn-' . $color . '  mb-2"
                       onclick="editButton(\'' . $routeUrl . '\', \'' . e($fullText) . '\')">
                    <i class="fa fa-pencil"></i>
                </button>';
        }
        return ' ';
    }
}

if (!function_exists('deleteBtn')) {
    function deleteBtn($route, $id = "", $text = ""): string
    {
        $routeUrl = route($route . '.destroy', $id);
        if (checkIfHasPermission(extractMainRouteSegment($routeUrl) . '-delete')) {
            $routeUrl = route($route . '.destroy', $id);
            return '<button type="button" class="btn btn-danger  mb-2"
                onclick="deleteButton(\'' . $routeUrl . '\')">
                <i class="fa fa-trash"></i>
            </button>';
        }
        return ' ';
    }
}
//<button type="submit" class="btn btn-primary">{{__('main.add')}}</button>


if (!function_exists('closeButton')) {
    function closeButton($route = "", $text = "", $color = 'label-secondary'): string
    {
        $fullText = ($text != "") ? $text : __("buttons.cancel");
        return '<button type="button" class="btn btn-' . $color . '" data-bs-dismiss="modal">' . $fullText . '</button>';
    }
}
if (!function_exists('showBtn')) {
    function showBtn($route, $id = "", $text = ""): string
    {
        $routeUrl = route($route . '.show', $id);
        if (checkIfHasPermission(extractMainRouteSegment($routeUrl) . '-read')) {
            return '<button type="button" class="btn btn-info  mb-2"
                onclick="showButton(\'' . $routeUrl . '\')">
                <i class="fa fa-eye"></i>
            </button>';
        }
        return ' ';
    }
}
