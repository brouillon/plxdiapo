<?php

/// Très important pour AJAX/IE Et Firefox
header('Content-type: text/html; charset=iso-8859-1');

/// Très important pour AJAX/IE
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

if (isset($_GET['image'])) {

    $pos = strpos($_GET['image'], 'data/images/');//TODO utiliser les variables pluX
    if ($pos) {

        $arrResult = array();

        $filename = basename($_GET['image']);

        $dir = substr($_GET['image'], $pos + strlen('data/images/'), -1 * strlen($filename));

        //TODO interdire l'usage de deux points dans le nom du dossier
        if (is_dir('../../data/images/'.$dir )) {

            $d = dir('../../data/images/'.$dir);

            while (false !== ($entry = $d->read())) {

                if(substr($entry, 0, 1) == '.' || $entry == $filename)
                    continue;

                $ext = get_file_ext($entry);

                if (in_array(strtolower($ext), array('png', 'jpg', 'jpeg', 'gif')))
                {
                    //pas les miniatures
                    if (substr($entry, -1 * (strlen($ext) + 4)) != '.tb.' . $ext) {

                        $arrResult[] = 'data/images/' . $dir . $entry;

                    }

                }

            }

            $d->close();

        }

        echo json_encode($arrResult);

    }


}

function get_file_ext($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    return $ext;
}