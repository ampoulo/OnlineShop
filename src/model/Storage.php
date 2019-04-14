<?php

interface Storage{
    /* Insère une nouvelle couleur dans la base. Renvoie l'identifiant
	 * de la nouvelle couleur. */
	public function create($id);

	/* Renvoie la couleur d'identifiant $id, ou null
	 * si l'identifiant ne correspond à aucune couleur. */
	public function read($id);

	/* Renvoie un tableau associatif id => Color
	 * contenant toutes les couleurs de la base. */
	public function readAll();

	/* Met à jour une couleur dans la base. Renvoie
	 * true si la modification a été effectuée, false
	 * si l'identifiant ne correspond à aucune couleur. */
	public function update();

	/* Supprime une couleur. Renvoie
	 * true si la suppression a été effectuée, false
	 * si l'identifiant ne correspond à aucune couleur. */
	public function delete($id);

	/* Vide la base. */
	public function deleteAll();
}
