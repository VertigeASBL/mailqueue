<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     API Mailqueue
 * @copyright  2014
 * @author     Vertige (Didier)
 * @licence    GNU/GPL
 * @package    SPIP\Mailqueue\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function mailqueue_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['mailqueues'] = 'mailqueues';
	$interfaces['table_des_tables']['mailqueues_destinataires'] = 'mailqueues_destinataires';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function mailqueue_declarer_tables_objets_sql($tables) {

	$tables['spip_mailqueues'] = array(
		'type' => 'mailqueue',
		'principale' => "oui",
		'field'=> array(
			"id_mailqueue"        => "bigint(21) NOT NULL",
			"sujet"              => "text NOT NULL DEFAULT ''",
			"html"               => "text NOT NULL DEFAULT ''",
			"texte"              => "text NOT NULL DEFAULT ''",
			"date_start"         => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"etat"               => "varchar(20)  DEFAULT '' NOT NULL",
			"date"               => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_mailqueue",
            "KEY etat" => "etat"
		),
		'titre' => "sujet AS titre, '' AS lang",
		'date' => "date",
		'champs_editables'  => array('sujet', 'html', 'texte', 'date_start', 'etat'),
		'champs_versionnes' => array('sujet', 'html', 'texte', 'date_start', 'etat'),
		'rechercher_champs' => array(),
		'tables_jointures'  => array(),
	);

	$tables['spip_mailqueues_destinataires'] = array(
		'type' => 'mailqueue_destinataire',
		'principale' => "oui",
		'table_objet_surnoms' => array('mailqueuedestinataire', 'mailqueue_destinataire'), // table_objet('mailqueu_destinataire') => 'mailqueu_destinataire'
		'field'=> array(
			"id_mailqueue" => "bigint(21) NOT NULL",
			"email"              => "varchar(320)  DEFAULT '' NOT NULL",
			"date_envoie"        => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"statut"             => "varchar(20)  DEFAULT '' NOT NULL",
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
            "KEY email" => "email",
			"KEY statut"         => "statut",
		),
		'titre' => "'' AS titre, '' AS lang",
		 #'date' => "",
		'champs_editables'  => array('email', 'date_envoie', 'statut'),
		'champs_versionnes' => array('email', 'date_envoie', 'statut'),
		'rechercher_champs' => array(),
		'tables_jointures'  => array(),
	);

	return $tables;
}