
    $requette= 'select 	
                                case when ste.lieu is null then st_p.lieu
                                        else ste.lieu
                                end sita,
                                case when ste.id is null then st_p.id
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
                                                        (sum(case when s_s.entree is null then 0 else s_s.entree end)*100 -
                                                        sum(case when s_s.consommation = 0 then 1 else 0 end)) = 0 
                                                            then 	
                                                                sum((case when s_s.entree is null then 0 else s_s.entree end))*100 	-
                                                                sum((case when s_s.consommation = 0 then 1 else 0 end))
                                                    else  
                                                    (select s.entree *100 from stock_site s where  s.rapport_id is null and s.materiel_id = 41 
                                                    and s.date_stock in (select max(ll.date_stock) from stock_site ll  where  ll.materiel_id = 41))  
                                            end
                                    else
                                            sum((case when s_s.entree is null then 0 else s_s.entree end))
                                        - sum((case when s_s.consommation is null then 0 else  s_s.consommation end))
                                end état		
                        from materiel mt
                        full join stock_site s_s on (s_s.materiel_id = mt.id)
                        left join site ste on (ste.id = s_s.site_id)
                        left join paf pf on (pf.id=s_s.paf_id)
                        left join site st_p on (st_p.id = pf.site_id)
                        group by sita,mt.materiel,pf.paf,sita_id,mt.id';

--- Etiquette

select st.lieu, pf.paf, mt.materiel,
	case when sum(- s_s.debut_serie + s_s.fin_serie+1)  is null then 0 else sum(- s_s.debut_serie + s_s.fin_serie+1) end -
    case when sum (s_s.consommation) is null then 0 else sum (s_s.consommation) end
from stock_site s_s
full join paf pf on (pf.id= s_s.paf_id)
left join materiel mt on (mt.id = s_s.materiel_id)
left join site st on (st.id = pf.site_id)
group by st.lieu, pf.paf, mt.materiel, st.id

having st.id = 1

---- Autre

select 	
			 ste.lieu ,
			mt.materiel,
			-- si papier ram 
			case
			     when mt.id = 41   then
						case  when
									(sum(case when s_s.entree is null then 0 else s_s.entree end)*100 -
									sum(case when s_s.consommation = 0 then 100 else 0 end)) != 0 
										then 	
											sum((case when s_s.entree is null then 0 else s_s.entree end))*100 	-
											sum((case when s_s.consommation = 0 then 100 else 0 end)) -
											(select  s.consommation  from stock_site s where  s.rapport_id is not null and s.materiel_id = 41 order by s.date_stock desc limit 1)
								else  
								(select  s.consommation  from stock_site s where  s.rapport_id is not null and s.materiel_id = 41 order by s.date_stock desc limit 1)  
						end
				 else
					sum((case when s_s.entree is null then 0 else s_s.entree end))
					- sum((case when s_s.consommation is null then 0 else  s_s.consommation end))
			end état		
 from materiel mt
full join stock_site s_s on (s_s.materiel_id = mt.id)
left join site ste on (ste.id = s_s.site_id)
group by ste.lieu,mt.materiel,mt.id,ste.id,mt.categorie_id
having mt.id != 39 and mt.categorie_id=2 and ste.id =1

--- Changement requette
 $requette= '
 select 	
			 ste.lieu ,
			mt.materiel,
			-- si papier ram 
			case
			     when mt.id = 41   then
						case  when
									(sum(case when s_s.entree is null then 0 else s_s.entree end)*100 -
									sum(case when s_s.consommation = 0 then 100 else 0 end)) != 0 
										then 	
											sum((case when s_s.entree is null then 0 else s_s.entree end))*100 	-
											sum((case when s_s.consommation = 0 then 100 else 0 end)) -
											(select  s.consommation  from stock_site s where  s.rapport_id is not null and s.materiel_id = 41 order by s.date_stock desc limit 1)
								else  
								(select  s.consommation  from stock_site s where  s.rapport_id is not null and s.materiel_id = 41 order by s.date_stock desc limit 1)  
						end
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

 
(select debut_serie from stock_site where paf_id =1  and debut_serie is not null  order by date_stock desc OFFSET 0 ROWS FETCH FIRST 1 ROW ONLY);

(select s_s.fin_serie from stock_site s_s where s_s.paf_id =1  and s_s.debut_serie is not null  order by s_s.date_stock desc OFFSET 0 ROWS FETCH FIRST 1 ROW ONLY);

------ Manomboka teo amle view -------
create view etat_etiquette as select st.id,st.lieu, pf.paf,pf.id as paf_id, mt.materiel,
	case when sum(- s_s.debut_serie + s_s.fin_serie+1)  is null then 0 else sum(- s_s.debut_serie + s_s.fin_serie+1) end -
    case when sum (s_s.consommation) is null then 0 else sum (s_s.consommation) end etat
from stock_site s_s
full join paf pf on (pf.id= s_s.paf_id)
left join materiel mt on (mt.id = s_s.materiel_id)
left join site st on (st.id = pf.site_id)
where   mt.id=39 
group by st.lieu, pf.paf, mt.materiel, st.id,pf.id

having st.id = 2
drop view etat_etiquette


select e_e.*, DIV(e_e.etat,500),
	(select debut_serie as debut
		from stock_site 
		where paf_id = e_e.paf_id 
			and debut_serie is not null  
		order by date_stock desc OFFSET DIV(e_e.etat,500) ROWS 
		FETCH FIRST 1 ROW ONLY)
from etat_etiquette e_e

select * from stock_site ss where ss.rapport_id=25
	
	

---------- rapport etat de stock -----------
create view etat_consommabme_ettiquettte as  select 
	'-'as num_bobine,
	pf.paf as boxpaf,
	ees.debut || '-' ||ees.fin as numero_bobine,
	ees.debut+(case when ees.etat>500 then ees.etat-500 else ees.etat end )-ss.consommation as debut,
	ees.debut+(case when ees.etat>500 then ees.etat-500 else ees.etat end ) as fin,
	ss.consommation as nb_consommee,
	case when ss.abimmees is  null then 0 else  ss.abimmees end,
	case when ss.cause is null then '-' else ss.cause end,
	ss.rapport_id
 from stock_site ss 
left join paf pf on (pf.id=ss.paf_id)
left join etiq_en_service ees on (ees.paf_id = ss.paf_id) 
where   pf.paf is not null 

----

create view etat_consommabme_autres as  select ss.rapport_id,ss.site_id,mt.materiel, ea.etat-ss.consommation as initial, ss.consommation as entrée, ea.etat as reste from stock_site ss 
left join etat_autres ea on(  ea.id = ss.site_id and ea.mat_id = ss.materiel_id)
left join materiel mt on(ss.materiel_id = mt.id)
where ss.materiel_id <> 39 

---
create view etat_etiquette AS  SELECT st.id,
    st.lieu,
    pf.paf,
    pf.id AS paf_id,
    mt.materiel,
    (
        CASE
            WHEN (sum((((- s_s.debut_serie) + s_s.fin_serie) + 1)) IS NULL) THEN (0)::numeric
            ELSE sum((((- s_s.debut_serie) + s_s.fin_serie) + 1))
        END - (
        CASE
            WHEN (sum(s_s.consommation) IS NULL) THEN (0)::bigint
            ELSE sum(s_s.consommation)
        END)::numeric) AS etat
   FROM (((stock_site s_s
     FULL JOIN paf pf ON ((pf.id = s_s.paf_id)))
     LEFT JOIN materiel mt ON ((mt.id = s_s.materiel_id)))
     LEFT JOIN site st ON ((st.id = pf.site_id)))
  WHERE (mt.id = 39)
  GROUP BY st.lieu, pf.paf, mt.materiel, st.id, pf.id

  ---
  CREATE VIEW ${schema}.${name} AS  SELECT ss.rapport_id,
    ss.site_id,
    mt.materiel,
        CASE
            WHEN (ss.materiel_id = 41) THEN (( SELECT s_s.consommation
               FROM stock_site s_s
              WHERE ((s_s.materiel_id = 41) AND (s_s.consommation IS NOT NULL))
              ORDER BY s_s.date_stock DESC
             OFFSET 1
             LIMIT 1))::bigint
            ELSE (ea.etat + ss.consommation)
        END AS initial,
        CASE
            WHEN (ss.materiel_id = 41) THEN 0
            ELSE ss.consommation
        END AS sortie,
        CASE
            WHEN (ss.materiel_id = 41) THEN (( SELECT s_s.consommation
               FROM stock_site s_s
              WHERE ((s_s.materiel_id = 41) AND (s_s.consommation IS NOT NULL))
              ORDER BY s_s.date_stock DESC
             OFFSET 0
             LIMIT 1))::bigint
            ELSE ea.etat
        END AS reste
   FROM ((stock_site ss
     LEFT JOIN etat_autres ea ON (((ea.id = ss.site_id) AND (ea.mat_id = ss.materiel_id))))
     LEFT JOIN materiel mt ON ((ss.materiel_id = mt.id)))
  WHERE (ss.materiel_id <> 39)
  ---
  CREATE VIEW ${schema}.${name} AS  SELECT '-'::text AS num_bobine,
    pf.paf AS boxpaf,
    ((ees.debut || '-'::text) || ees.fin) AS numero_bobine,
    (((ees.debut)::numeric +
        CASE
            WHEN (ees.etat > (500)::numeric) THEN (ees.etat - (500)::numeric)
            ELSE ees.etat
        END) - (ss.consommation)::numeric) AS debut,
    ((ees.debut)::numeric +
        CASE
            WHEN (ees.etat > (500)::numeric) THEN (ees.etat - (500)::numeric)
            ELSE ees.etat
        END) AS fin,
    ss.consommation AS nb_consommee,
        CASE
            WHEN (ss.abimmees IS NULL) THEN 0
            ELSE ss.abimmees
        END AS abimmees,
        CASE
            WHEN (ss.cause IS NULL) THEN '-'::character varying
            ELSE ss.cause
        END AS cause,
    ss.rapport_id
   FROM ((stock_site ss
     LEFT JOIN paf pf ON ((pf.id = ss.paf_id)))
     LEFT JOIN etiq_en_service ees ON ((ees.paf_id = ss.paf_id)))
  WHERE (pf.paf IS NOT NULL)