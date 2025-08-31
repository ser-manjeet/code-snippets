<?php
/**
 * Kadence: Override Default Icon with Custom SVG Icon
 *
 * This filter replaces or adds a custom SVG icon into the Kadence icon system.
 * 
 * Use Case:
 * - Kadence blocks (e.g. Buttons, Icons) can use named icons.
 * - If you assign an icon with the name `account3`, Kadence will call this filter.
 * - This code injects a custom SVG for the icon name `account3`.
 * 
 * Usage in Kadence UI:
 * - Select an icon block or button with an icon.
 * - In the "Icon" field, manually enter `account3` as the icon name.
 * - Kadence will use this custom SVG instead of the default.
 */

add_filter( 'kadence_svg_icon', function( $icon, $name ) {
    if ( 'account3' === $name ) {
        $icon = '<span class="kadence-svg-iconset">
            <svg class="kadence-svg-icon kadence-account3-svg" width="41" height="42" viewBox="0 0 41 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20.7049 23.7797C20.6708 23.7797 20.6195 23.7797 20.5854 23.7797C20.5341 23.7797 20.4658 23.7797 20.4145 23.7797C16.5366 23.6601 13.6324 20.6364 13.6324 16.9122C13.6324 13.1197 16.7245 10.0276 20.517 10.0276C24.3095 10.0276 27.4016 13.1197 27.4016 16.9122C27.3845 20.6535 24.4633 23.6601 20.7562 23.7797C20.722 23.7797 20.722 23.7797 20.7049 23.7797ZM20.4999 12.5731C18.1083 12.5731 16.1779 14.5206 16.1779 16.8951C16.1779 19.2356 18.0058 21.1318 20.3291 21.2172C20.3804 21.2001 20.5512 21.2001 20.722 21.2172C23.0112 21.0976 24.8049 19.2185 24.822 16.8951C24.822 14.5206 22.8916 12.5731 20.4999 12.5731Z" fill="currentColor"/>
                <path d="M20.5 39.5306C15.9046 39.5306 11.5142 37.8222 8.11459 34.7131C7.80709 34.4397 7.67042 34.0297 7.70459 33.6368C7.92667 31.6039 9.19084 29.7077 11.2921 28.3068C16.3829 24.9243 24.6342 24.9243 29.7079 28.3068C31.8092 29.7247 33.0733 31.6039 33.2954 33.6368C33.3467 34.0468 33.1929 34.4397 32.8854 34.7131C29.4858 37.8222 25.0954 39.5306 20.5 39.5306ZM10.3867 33.2952C13.2225 35.6697 16.7929 36.9681 20.5 36.9681C24.2071 36.9681 27.7775 35.6697 30.6133 33.2952C30.3058 32.2531 29.4858 31.2452 28.2729 30.4252C24.0704 27.6235 16.9467 27.6235 12.71 30.4252C11.4971 31.2452 10.6942 32.2531 10.3867 33.2952Z" fill="currentColor"/>
                <path d="M20.5 39.5306C10.3695 39.5306 2.13538 31.2964 2.13538 21.166C2.13538 11.0356 10.3695 2.8014 20.5 2.8014C30.6304 2.8014 38.8645 11.0356 38.8645 21.166C38.8645 31.2964 30.6304 39.5306 20.5 39.5306ZM20.5 5.3639C11.7875 5.3639 4.69788 12.4535 4.69788 21.166C4.69788 29.8785 11.7875 36.9681 20.5 36.9681C29.2125 36.9681 36.302 29.8785 36.302 21.166C36.302 12.4535 29.2125 5.3639 20.5 5.3639Z" fill="currentColor"/>
            </svg>
        </span>';
    }
    return $icon;
}, 10, 2 );
