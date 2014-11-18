<?php

namespace App\Model;

use Nette;

 
/**
 * @author 
 */
class Oblast extends Table
{

    /**
    * @var string
    */
    protected $tableName = 'Oblast';

    public function getSeznamOblasti()
    {
        return($this->findAll()->order("jmeno"));
    }
    
    /*
     * DEPRECATED - pouzij formatujOblastiSAP(getSeznamOblasti());
    public function getSeznamOblastiSAP()
    {
        $oblasti = $this->getSeznamOblasti();
        return($this->formatujOblastiSAP($oblasti));
    }
    */
    
    public function getSeznamOblastiBezAP()
    {
	   $oblasti = $this->getSeznamOblasti();
	   return($oblasti->fetchPairs('id', 'jmeno'));
    }
    
    public function getSeznamSpravcu($IDoblasti) {
	   return($this->find($IDoblasti)->related("SpravceOblasti.Oblast_id")->fetchPairs('Uzivatel_id','Uzivatel'));
    }
    
    public function formatujOblastiSAP($oblasti)
    {
        $aps = array();
        foreach ($oblasti as $oblast) {
			$apcka_oblasti = $oblast->related('Ap.Oblast_id');
			foreach($oblast->related('Ap.Oblast_id') as $apid => $ap) {
				if(count($apcka_oblasti) == 1)
					$aps[$apid] = $ap->jmeno;
				else
					$aps[$apid] = $oblast->jmeno.' - '.$ap->jmeno;
			}
		}
		return($aps);
    }
}