<?php

function parse_youtube_url($url){
    $problematic_part = 'watch?v=';
    $problematic_part_2 = 'embed?v=';
    if (strpos($url, $problematic_part) !== false) {
        $ret = str_replace($problematic_part,"embed/",$url);
        return $ret;
    }
    else if (strpos($url, $problematic_part_2) !== false) {
        $ret = str_replace($problematic_part_2,"embed/",$url);
        return $ret;
    }
    return $url;
}
function show_youtube_embed($url){

    $url = parse_youtube_url($url);   // make sure the Youtube URL has the correct Embed endpoint
    $ret = '<iframe width="560" height="315" src="' . $url . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen></iframe>';
    return $ret;
}
