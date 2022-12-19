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
    public function getEtatStockParSite(int $idSite)
    {
		$retours ['autres'] =array();
		$retours ['etiquette']=array();
        $reqAutres= '
			select 	
					ste.lieu ,
				mt.materiel,
				-- si papier ram 
				case
						when mt.id = 41   then
							-- case  when
							--			(sum(case when s_s.entree is null then 0 else s_s.entree end)*100 -
							--			sum(case when s_s.consommation = 0 then 100 else 0 end)) != 0 
							--				then 	
							--					sum((case when s_s.entree is null then 0 else s_s.entree end))*100 	-
							--					sum((case when s_s.consommation = 0 then 100 else 0 end)) -
							--					(select  s.consommation  from stock_site s where  s.rapport_id is not null and s.materiel_id = 41 order by s.date_stock desc limit 1)
							--		else  
							--		(select  s.consommation  from stock_site s where  s.rapport_id is not null and s.materiel_id = 41 order by s.date_stock desc limit 1)  
							--end
							(select  	
								ss.consommation 
							from stock_site ss 
							where ss.materiel_id = mt.id and ss.site_id = ste.id and ss.consommation is not null   
							order by ss.date_stock desc  
							limit 1 )
						else
						sum((case when s_s.entree is null then 0 else s_s.entree end))
						- sum((case when s_s.consommation is null then 0 else  s_s.consommation end))
				end état		
			from materiel mt
			full join stock_site s_s on (s_s.materiel_id = mt.id)
			left join site ste on (ste.id = s_s.site_id)
			group by ste.lieu,mt.materiel,mt.id,ste.id,mt.categorie_id
			having mt.id != 39 and mt.categorie_id=2 and ste.id =?
			';



		$reqEtiquette='
		select st.lieu, pf.paf, mt.materiel,
			case when sum(- s_s.debut_serie + s_s.fin_serie+1)  is null then 0 else sum(- s_s.debut_serie + s_s.fin_serie+1) end -
			case when sum (s_s.consommation) is null then 0 else sum (s_s.consommation) end état
		from stock_site s_s
		full join paf pf on (pf.id= s_s.paf_id)
		left join materiel mt on (mt.id = s_s.materiel_id)
		left join site st on (st.id = pf.site_id)
		group by st.lieu, pf.paf, mt.materiel, st.id

		having st.id = ?
		';

		$retours ['autres'] = $this->connection->fetchAllAssociative( $reqAutres,[$idSite] );
		$retours ['etiquette'] =  $this->connection->fetchAllAssociative( $reqEtiquette,[$idSite] );     
			return $retours;
    }
	public function getEtatConsommbale(int $idRapport)
    {
		$retours ['autres'] =array();
		$retours ['etiquette']=array();
        $reqAutres= 'select*from etat_consommabme_autres where rapport_id=?';
		$reqEtiquette='select*from etat_consommabme_ettiquettte where rapport_id = ?';

		$retours ['autres'] = $this->connection->fetchAllAssociative( $reqAutres,[$idRapport] );
		$retours ['etiquette'] =  $this->connection->fetchAllAssociative( $reqEtiquette,[$idRapport] );     
			return $retours;
    }
}

?>