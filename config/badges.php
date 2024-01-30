<?php

return [
    'beginner' => [
        'min_achievements' => 0,
        'max_achievements' => 3,
        'name' => 'Beginner',
    ],
    'intermediate' => [
        'min_achievements' => 4,
        'max_achievements' => 7,
        'name' => 'Intermediate',
    ],
    'advanced' => [
        'min_achievements' => 8,
        'max_achievements' => 9,
        'name' => 'Advanced',
    ],
    'master' => [
        'min_achievements' => 10,
        'max_achievements' => 50,  //add the max limit in env file.This is for testing
        'name' => 'Master',
    ],
];
