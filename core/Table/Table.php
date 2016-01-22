<?php
namespace Core\Table;

use Core\Database\Database;

class Table
{
    protected $table;
    protected $db;
    protected $tableEncours;

    public function __construct(Database $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name)) . 's';
        }
    }
    // Cas normal, j'affiche tout
    public function all(){
        return $this->query('SELECT * FROM ' . $this->table);
    }
	
	// Cas : Il faut etre admin pour voir toutes les langues
    public function allInUserLang(){
        if ($_SESSION['level']=='1'){
            return $this->query('SELECT * FROM ' . $this->table .' ORDER BY id_group_lang');
        }
        else{
            return $this->query("SELECT * FROM " . $this->table . " WHERE lang = '" . $_SESSION['lang'] . "'");
        }
    }
	
	// Cas : Il faut etre admin pour voir toutes les langues ET AFFICHER AVEC LA PAGINATION
    public function allInUserLangPagination($start,$epp){
        if ($_SESSION['level']=='1'){
            return $this->query('SELECT * FROM ' . $this->table .'  LIMIT ' . $start . ',' . $epp);
			// .' ORDER BY id_group_lang'
        }
        else{
            return $this->query("SELECT * FROM " . $this->table . " WHERE lang = '" . $_SESSION['lang'] . "' LIMIT " . $start . "," . $epp);
        }
    }
	
	// Nombre d'entrer de la requete
	public function CountEntrer(){
		// Calcul du nombre total d'entrées $total dans la table pagination
        return $this->query('SELECT COUNT(*) FROM ' . $this->table);
		
    }
	
	// Pagination
	/**
	* Affiche la pagination à l'endroit où cette fonction est appelée
	* @param string $url L'URL ou nom de la page appelant la fonction, ex: 'index.php' ou 'http://example.com/'
	* @param string $link La nom du paramètre pour la page affichée dans l'URL, ex: '?page=' ou '?&p='
	* @param int $total Le nombre total de pages
	* @param int $current Le numéro de la page courante
	* @param int $adj (facultatif) Le nombre de pages affichées de chaque côté de la page courante (défaut : 3)
	* @return La chaîne de caractères permettant d'afficher la pagination
	*/
	public function paginate($url, $link, $total, $current, $adj=3) {
		// Initialisation des variables
		$prev = $current - 1; // numéro de la page précédente
		$next = $current + 1; // numéro de la page suivante
		$penultimate = $total - 1; // numéro de l'avant-dernière page
		$pagination = ''; // variable retour de la fonction : vide tant qu'il n'y a pas au moins 2 pages
		if ($total > 1) {
			var_dump($total);die;
			// Remplissage de la chaîne de caractères à retourner
			$pagination .= "<div class=\"pagination\">\n";
			/* =================================
			 *  Affichage du bouton [précédent]
			 * ================================= */
			if ($current == 2) {
				// la page courante est la 2, le bouton renvoie donc sur la page 1, remarquez qu'il est inutile de mettre $url{$link}1
				$pagination .= "<a href=\"{$url}\">◄</a>";
			} elseif ($current > 2) {
				// la page courante est supérieure à 2, le bouton renvoie sur la page dont le numéro est immédiatement inférieur
				$pagination .= "<a href=\"{$url}{$link}{$prev}\">◄</a>";
			} else {
				// dans tous les autres, cas la page est 1 : désactivation du bouton [précédent]
				$pagination .= '<span class="inactive">◄</span>';
			}
			/**
			 * Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
			 * - CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
			 * - CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
			 */
			/* ===============================================
			 *  CAS 1 : au plus 12 pages -> pas de troncature
			 * =============================================== */
			if ($total < 7 + ($adj * 2)) {
				// Ajout de la page 1 : on la traite en dehors de la boucle pour n'avoir que index.php au lieu de index.php?p=1 et ainsi éviter le duplicate content
				$pagination .= ($current == 1) ? '<span class="active">1</span>' : "<a href=\"{$url}\">1</a>"; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'
				// Pour les pages restantes on utilise itère
				for ($i=2; $i<=$total; $i++) {
					if ($i == $current) {
						// Le numéro de la page courante est mis en évidence (cf. CSS)
						$pagination .= "<span class=\"active\">{$i}</span>";
					} else {
						// Les autres sont affichées normalement
						$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
					}
				}
			}
			/* =========================================
			 *  CAS 2 : au moins 13 pages -> troncature
			 * ========================================= */
			else {
				/**
				 * Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
				 * l'affichage sera de neuf numéros de pages à gauche ... deux à droite
				 * 1 2 3 4 5 6 7 8 9 … 16 17
				 */
				if ($current < 2 + ($adj * 2)) {
					// Affichage du numéro de page 1
					$pagination .= ($current == 1) ? "<span class=\"active\">1</span>" : "<a href=\"{$url}\">1</a>";

					// puis des huit autres suivants
					for ($i = 2; $i < 4 + ($adj * 2); $i++) {
						if ($i == $current) {
							$pagination .= "<span class=\"active\">{$i}</span>";
						} else {
							$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
						}
					}

					// ... pour marquer la troncature
					$pagination .= '&hellip;';

					// et enfin les deux derniers numéros
					$pagination .= "<a href=\"{$url}{$link}{$penultimate}\">{$penultimate}</a>";
					$pagination .= "<a href=\"{$url}{$link}{$total}\">{$total}</a>";
				}
				/**
				 * Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
				 * l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite
				 * 1 2 … 5 6 7 8 9 10 11 … 16 17
				 */
				elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) ) {
					// Affichage des numéros 1 et 2
					$pagination .= "<a href=\"{$url}\">1</a>";
					$pagination .= "<a href=\"{$url}{$link}2\">2</a>";
					$pagination .= '&hellip;';

					// les pages du milieu : les trois précédant la page courante, la page courante, puis les trois lui succédant
					for ($i = $current - $adj; $i <= $current + $adj; $i++) {
						if ($i == $current) {
							$pagination .= "<span class=\"active\">{$i}</span>";
						} else {
							$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
						}
					}

					$pagination .= '&hellip;';

					// et les deux derniers numéros
					$pagination .= "<a href=\"{$url}{$link}{$penultimate}\">{$penultimate}</a>";
					$pagination .= "<a href=\"{$url}{$link}{$total}\">{$total}</a>";
				}
				/**
				 * Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
				 * l'affichage sera deux numéros de pages à gauche ... neuf à droite
				 * 1 2 … 9 10 11 12 13 14 15 16 17
				 */
				else {
					// Affichage des numéros 1 et 2
					$pagination .= "<a href=\"{$url}\">1</a>";
					$pagination .= "<a href=\"{$url}{$link}2\">2</a>";
					$pagination .= '&hellip;';

					// puis des neuf derniers numéros
					for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++) {
						if ($i == $current) {
							$pagination .= "<span class=\"active\">{$i}</span>";
						} else {
							$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
						}
					}
				}
			}

			/* ===============================
			 *  Affichage du bouton [suivant]
			 * =============================== */
			if ($current == $total)
				$pagination .= "<span class=\"inactive\">►</span>\n";
			else
				$pagination .= "<a href=\"{$url}{$link}{$next}\">►</a>\n";

			// Fermeture de la <div> d'affichage
			$pagination .= "</div>\n";
		}

		return ($pagination);
	}

    public function lastId(){
        return $this->query('SELECT * FROM ' . $this->table . ' WHERE id=LAST_INSERT_ID()');
    }

    public function find($id){
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
	}

    public function update($id, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $sql_part = implode(', ', $sql_parts);
        //var_dump($fields);die;
        return $this->query("UPDATE {$this->table} SET $sql_part, date_update = NOW() WHERE id = ?", $attributes, true);
    }



    public function delete($id){
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
    }


    public function create($fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        //var_dump($attributes);
        $this->query("INSERT INTO {$this->table} SET $sql_part, date_insert = NOW()", $attributes, true);
    }




    public function extract($key, $value){
        //var_dump($value);
        $records = $this->all();
        $return = [];
        foreach($records as $v){
            $return[$v->$key] = $v->$value;
        }

        return $return;
    }


    /*
     * Je remplace le mot table par entity... entity est
     */

    public function query($statement, $attributes = null, $one = false){
        // C'est un requete préparée
        if($attributes){
            // la base de donnée est contenu dans l'objet... Je prépare donc ma requete
            return $this->db->prepare(
                $statement, // requete
                $attributes, // Les attributs envoyés
                str_replace('Table', 'Entity', get_class($this)), // La class (les entitées correspondent aux enregistrements => 1 enregistrement = 1 objet.  soit ojet game, objet news... )
                $one
            );
            // Je n'est pas d'attribut, je souhaite exécuter la requête
        } else {
            return $this->db->query(
                $statement,
                str_replace('Table', 'Entity', get_class($this)),
                $one
            );
        }

    }

}