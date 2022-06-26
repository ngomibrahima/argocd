<?php

namespace App\Exports;

use App\Models\Cadeau;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeclarationExport implements FromCollection
{

    public function __construct($debut, $fin){
        $this->debut = $debut;
        $this->fin = $fin;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $declas = Cadeau::whereBetween('date', [$this->debut, $this->fin])->get();

        $declarations = new Collection();
        $heading = (object)['date' => "Date", 'nature' => 'Nature', 'sens' => 'Sens', 'contexte' => "Contexte",'declarant' => 'Declarant', 'direction' => "Direction", 'montant' => 'Montant',
            'description' => 'Description', 'resHierarchique' => "Responsable Hierarchique", 'statut' => "Statut", 'structureImp' => "Structures Impliquées", 'persImp' => "Personnes Impliquées"];
        $declarations->push($heading);

        foreach ($declas as $decla){
            $structures = "";
            $implications = "";
            foreach ($decla->implications as $implication){
                $structures = $structures." ".$implication->structure;
                $implications = $implications. " ".$implication->prenom." ".$implication->nom;
            }
            $value = (object)['date' => $decla->date, 'nature' => $decla->nature->nom, 'sens' => $decla->sens, 'contexte' => $decla->contexte ,
                'declarant' => $decla->user->name, 'direction' => $decla->direction, 'montant' => $decla->montant, 'description' => html_entity_decode(strip_tags($decla->description)) ,
                'resHierarchique' => $decla->sup_hierarchique, 'statut' => $decla->statut,  'structureImp' => $structures, 'persImp' => $implications];
            $declarations->push($value);
        }

        return $declarations;
    }
}
