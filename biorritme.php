<?php
class Biorritme {
    private $nom;
    private $naixement;
    private $resultats = [];
    private $arrPeriodes = array("físic"=>23, "emotiu"=>28, "intelectual"=>33);
  

    public function __construct($naixement, $nom) {
        $this->naixement = new DateTime($naixement);
        $this->nom = htmlspecialchars($nom);
    }
 
    public function getNom() {
        return $this->nom;
    }

    public function getNaixement() {
        return $this->naixement->format('d/m/Y');
    }

    public function calculBiorritme() {
       $avui = new DateTime();
        $interval = $this->naixement->diff($avui);
        $diesTotals = $interval->days;

        foreach ($this->arrPeriodes as $clau => $P) {
            $cicles = $diesTotals / $P;
            $radians = $cicles * 2 * M_PI;
            $valorB = sin($radians);
            
            $percentatge = ($valorB + 1) * 50;
            $this->resultats[$clau] = round($percentatge, 2);
        }
        return $this->resultats;
    }

    public function saveCalculBiorritmeToJson($values) {
        $file_name = "dades_biorritmes.json";
        $data = [];

        if (file_exists($file_name)) {
            $json_data = file_get_contents($file_name);
            $data = json_decode($json_data, true) ?? [];
        }

        $nouRegistre = [
            "nom" => $this->nom,
            "data_naixement" => $this->getNaixement(),
            "data_calcul" => date('d/m/Y'),
            "valors" => $values
        ];

        array_push($data, $nouRegistre);
        file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));  
    }

    public function tableCalculBiorritmeJsonFile() {

        $file_name = "dades_biorritmes.json";
        if (!file_exists($file_name)) return "<p>No hi ha dades enregistrades.</p>";

        $data = json_decode(file_get_contents($file_name), true);
        
        $html_table = "<table border='1' style='width:100%; border-collapse: collapse; text-align: left;'>
                        <thead>
                            <tr>
                                <th>Nom</th><th>Naixement</th><th>Físic</th><th>Emotiu</th><th>Intel·lectual</th>
                            </tr>
                        </thead><tbody>";

        foreach (array_reverse($data) as $reg) {
            $html_table .= "<tr>
                <td>{$reg['nom']}</td>
                <td>{$reg['data_naixement']}</td>
                <td>{$reg['valors']['físic']}%</td>
                <td>{$reg['valors']['emotiu']}%</td>
                <td>{$reg['valors']['intelectual']}%</td>
            </tr>";
        }
        $html_table .= "</tbody></table>";
        return $html_table;
    }
}
?>