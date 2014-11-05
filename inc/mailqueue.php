<?php

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Fonction de création de queue d'email
 *
 * @param mixed $sujet
 * @param mixed $html
 * @param mixed $texte
 * @access public
 */
function inc_mailqueue_dist($sujet, $html=null, $texte=null) {

    // On bloque en cas de nullité total du message
    if (empty($html) and empty($texte))
        return false;

    include_spip('action/editer_objet');
    // A prioris on a pas besoin de gérer plus de chose, facteur ce dérbouillera avec html et/ou texte
    $id_mailqueue = objet_inserer(
        'mailqueue',
        null,
        array(
            'sujet' => $sujet,
            'html' => $html,
            'texte' => $texte,
            'etat' => 'envoie'
        )
    );

    return $id_mailqueue;
}