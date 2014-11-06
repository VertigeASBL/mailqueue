<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('action/editer_objet');

// Cette fonction est appeler a la fin d'un envoie de lot pour déterminé s'il faut fermer ou non la mailqueue
function test_fin_queue($id_mailqueue) {
    // On compte le nombre de destinataire dans la mailqueue
    $destinataires = sql_count('spip_mailqueues_destinataires', 'id_mailqueue='.intval($id_mailqueue));

    //Si il n'y a plus de destinataire, rideau !
    if ($destinataire <= 0)
        objet_modifier('mailqueue', $id_mailqueue, array('statut' => 'termine'));
}

// Marque un mail comme envoyé
function mail_ok($email) {
    sql_updateq(
        'spip_mailqueues_destinataires',
        array('statut' => 'envoye', 'date_envoie' => 'NOW()'),
        'email='.sql_quote($email)
    );
}

// Marque un mail non envoyé
function mail_echec($email) {
    sql_updateq(
        'spip_mailqueues_destinataires',
        array('statut' => 'echec', 'date_envoie' => 'NOW()'),
        'email='.sql_quote($email)
    );
}

/**
 * Envoyer un lot d'email de la mailqueue
 *
 * @access public
 */
function action_envoyer_lot_dist() {

    // Armé facteur pour être pret à tirer
    $envoyer_mail = charger_fonction('envoyer_mail', 'inc');

    // On séléctionne les mailqueue qui sont en envoie
    $mailqueues = sql_allfetsel(
        'id_mailqueue, sujet, html, texte',
        'spip_mailqueues',
        'etat='.sql_quote('envoie')
    );

    // pour chaque mailqueue, on va envoyer un lot de mail
    foreach ($mailqueues as $mailqueue) {
        // Séléction du prochain lot
        $lot = sql_allfetsel(
            'email',
            'spip_mailqueues_destinataires',
            'id_mailqueue='.intval($mailqueue['id_mailqueue']).' AND statut='.sql_quote('attente'),
            '', // groupe by on s'en fou
            '', // Order by on s'en fou aussi
            MAILQUEUE_CADENCE // On limite selon la configuration de la cadence
        );

        foreach ($lot as $email) {
            $test_envoie = $envoyer_mail(
                $email['email'],
                $mailqueue['sujet'],
                array(
                    'html' => $mailqueue['html'],
                    'texte' => $mailqueue['texte']
                )
            );

            // On modifier le statut du mail
            if ($test_envoie)
                mail_ok($email['email']);
            else
                mail_echec($email['email']);
        }
        // Est-ce qu'on est à la fin de la mailqueue
        test_fin_queue($mailqueue['id_mailqueue']);
    }
}