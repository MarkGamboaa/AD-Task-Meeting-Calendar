<?php
function renderError($message, $type = 'error')
{
    $class = '';
    $icon = '';

    switch ($type) {
        case 'error':
            $class = 'error';
            $icon = '❌';
            break;
        case 'success':
            $class = 'success';
            $icon = '✅';
            break;
        case 'info':
            $class = 'info';
            $icon = 'ℹ️';
            break;
        default:
            $class = 'error';
            $icon = '❌';
    }

    return "<div class=\"{$class}\">{$icon} {$message}</div>";
}

function showError($message, $type = 'error')
{
    echo renderError($message, $type);
}
?>