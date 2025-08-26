<?php

return [
    "default_duration" => env("TOAST_DEFAULT_DURATION", 5000),
    "default_position" => env("TOAST_DEFAULT_POSITION", "top-right"),
    "max_toasts" => env("TOAST_MAX_TOASTS", 5),
    "show_progress" => env("TOAST_SHOW_PROGRESS", false),

    "positions" => [
        "top-left" => "top-4 left-4",
        "top-center" => "top-4 left-1/2 transform -translate-x-1/2",
        "top-right" => "top-4 right-4",
        "middle-left" => "top-1/2 left-4 transform -translate-y-1/2",
        "middle-center" => "top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2",
        "middle-right" => "top-1/2 right-4 transform -translate-y-1/2",
        "bottom-left" => "bottom-4 left-4",
        "bottom-center" => "bottom-4 left-1/2 transform -translate-x-1/2",
        "bottom-right" => "bottom-4 right-4",
    ],

    "themes" => [
        "default" => [
            "container" => "bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700",
            "text" => "text-sm text-gray-700 dark:text-neutral-400",
        ],
        "minimal" => [
            "container" => "rounded-lg shadow-lg border-none",
            "text" => "text-sm text-white",
        ],
    ]
];