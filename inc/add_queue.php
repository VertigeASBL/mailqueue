<?php

if (!defined("_ECRIRE_INC_VERSION")) return;



/**
 * Fonction d'ajout d'email à une mailqueue
 *
 * @param int $id_mailqueue
 * @param string $email
 * @access public
 */
function inc_add_queue_dist($id_mailqueue, $email) {

    // On vérifie l'email avant de l'ajouter,
    // on ne sais jamais, les gens ne sont pas tous sain d'esprit
    $verifier = charger_fonction('verifier', 'inc');
    if ($verifier($email, 'email'))
        return false;

    include_spip('action/editer_objet');
    $id_queue = objet_inserer(
        'mailqueue_destinataire',
        null,
        array(
            'email' => $email,
            'statut' => 'attente'
        )
    );

    return $id_queue;
}