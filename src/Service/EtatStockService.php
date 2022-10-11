<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class EtatStockService
{
    private $connection;
  
    public function __construct(Connection $connection)
    {
        $this->connection= $connection;
    }
    public function getEtatStockParSite(int $idSite=null)
    {
        $requette= 'select 	
							case when ste.lieu is null then st_s.lieu
											else ste.lieu
									end sita,
							case when ste.id is null then st_s.id
											else ste.id
									end sita_id,
							mt.materiel,
							pf.paf,
									-- si etiquette 	
									case when mt.id = 39 then
										case when sum(s_s.fin_serie-s_s.debut_serie+1) is null then 0 else sum(s_s.fin_serie-s_s.debut_serie+1) end				 -
										case when sum(s_s.consommation) is null then 0 else sum(s_s.consommation) end
									-- si papier ram 
										when mt.id = 41   then
												case  when
															(sum(case when ss.entree is null then 0 else ss.entree end)*100 -
															sum(case when ss.consommation = 0 then 1 else 0 end)) != 0 
																then 	
																	sum((case when ss.entree is null then 0 else ss.entree end))*100 	-
																	sum((case when ss.consommation = 0 then 1 else 0 end))
														else  
														(select entree  from stock_site s where  s.rapport_id is null and s.materiel_id = 41 
														and s.date_stock in (select max(ll.date_stock) from stock_site ll))  
												end
										else
												sum((case when ss.entree is null then 0 else ss.entree end))
											- sum((case when ss.consommation is null then 0 else  ss.consommation end))
									end état
						from site ste
						left join paf pf on (pf.site_id =ste.id)
						left join stock_site s_s on (s_s.paf_id = pf.id)
						full join materiel mt on (mt.id = s_s.materiel_id)
						left join stock_site ss on (ss.materiel_id = mt.id)
						left join site st_s on (st_s.id = ss.site_id)	 
						group by sita,mt.materiel,pf.paf,mt.id,sita_id
';
            if ($idSite) {
                $having= ' having case when ste.id is null then st_s.id else ste.id end = ?';
                $retours= $this->connection->fetchAllAssociative( $requette.$having,[$idSite] );
            } else {
                $retours= $this->connection->fetchAllAssociative( $requette);
            } 
        ;
        return $retours;
    }
    public function getEtatStockGlobal(int $idSite): array
    {
        $retours = array();
        return $retours;
    }

   
}

?>