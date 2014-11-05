<?php
/**
 * Utilisations de pipelines par API Mailqueue
 *
 * @plugin     API Mailqueue
 * @copyright  2014
 * @author     Vertige (Didier)
 * @licence    GNU/GPL
 * @package    SPIP\Mailqueue\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

function mailqueue_taches_generales_cron($taches){

    $taches['mailqueue_envoie'] = MAILQUEUE_FREQUENCE;

    return $taches;
}