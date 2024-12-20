<?php

// these should not have defaults, better to keep it in .env only away from code
return [
    'minecraft_avatar_base_url' => env('MINECRAFT_AVATAR_BASE_URL', 'https://crafatar.com/avatars'),
    'minecraft_url_for_id' => env('MINECRAFT_URL_FOR_ID', 'https://sessionserver.mojang.com/session/minecraft/profile/'),
    'minecraft_url_for_username' => env('MINECRAFT_URL_FOR_USERNAME', 'https://api.mojang.com/users/profiles/minecraft/'),
    'steam_url_for_id' => env('STEAM_URL_FOR_ID', 'https://ident.tebex.io/usernameservices/4/username/'),
    // the below ones are the same, but for consistency and if case we need to change to different ones
    'xbl_url_for_id' => env('XBL_URL_FOR_ID', 'https://ident.tebex.io/usernameservices/3/username/'),
    'xbl_url_for_username' => env('XBL_URL_FOR_USERNAME', 'https://ident.tebex.io/usernameservices/3/username/'),
];
