<?php
//teste si la chaine $haystack contient la chaine $needle
//cette fonction existe à partir de php 8
//d'où le test "function_exists" pour la définir que si elle n'existe pas déjà
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

//teste l'extension pour verifier qu'il s'agit bien d'une image
//et retourne l'extension si il s'agit d'un jpg ou png ou gif
function extensionImage($url)
{
	if (str_contains($url,'.jpg')||str_contains($url,'.jpeg')||str_contains($url,'.JPEG')||str_contains($url,'.JPG')) return "jpg";
	else if (str_contains($url,'.png')||str_contains($url,'.PNG')) return "png";
	else if (str_contains($url,'.gif')||str_contains($url,'.GIF')) return "gif";
	else return "";
}

//fonction permettant la récupération de l'url de l'image accompagnant
//on peut trouver l'image dans media ou dans enclosure
//on vérifie aussi que l'extension correspond à celle d'une image (d'autres medias comme du son ou de la vidéo peuvent
// être proposés)
function getURLImage($nouvelle)
{
    if (count($nouvelle->children('media', True)) != 0) {
        $url_image = $nouvelle->children('media', True)->content->attributes()['url'];
    } else {
        if (isset($nouvelle->enclosure)) {
            $url_image = $nouvelle->enclosure->attributes()['url'];
        }
    }

    if (isset($url_image)&&(extensionImage($url_image)!="")) {
        return $url_image;
    } else {
        return "";
    }
}



?>
