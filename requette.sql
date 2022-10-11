--Etiquette
select  s.lieu,p.paf , 
	(( 
		select count(sss.*) from stock_site sss
		where sss.materiel_id =ss.materiel_id and sss.debut_serie is not null and sss.paf_id= p.id
		group by  sss.paf_id 
	)*500)-sum(ss.consommation) as état  from paf p
join site s on (s.id = p.site_id )
join stock_site ss on (ss.paf_id = p.id)
group by s.lieu,p.paf,ss.materiel_id,p.id,s.id
having s.id=

select 
	case
		when pf.id is null then ste.lieu
		else st.lieu
	end site,
	mt.materiel,pf.paf
 	from materiel mt 
	left join stock_site s_s on (s_s.materiel_id = mt.id)
	left join paf pf on (pf.id = s_s.paf_id)
	left join site st on (st.id = pf.site_id)
	left join site ste on (ste.id = s_s.site_id)

having mt.categorie_id =2




select
	case
		when pf.id is not null then st.lieu
		else ste.lieu
	end site,
	mt.materiel,pf.paf,pf.id,
	case
		when mt.materiel = 'Etiquette' then ((( 
				select count(sss.*) from stock_site sss
				where sss.materiel_id =s_s.materiel_id and sss.debut_serie is not null and sss.paf_id= pf.id
				group by  sss.paf_id 
			)*500)-sum(s_s.consommation))
		else sum(s_s.entree)-sum(s_s.consommation)
	end etat
from stock_site s_s  
	left join materiel mt on ( mt.id=s_s.materiel_id)
	left join paf pf on (pf.id = s_s.paf_id)
	left join site ste on (ste.id = s_s.site_id)
	left join site st on (st.id = pf.site_id)
group by ste.lieu, st.lieu,pf.paf,pf.id,mt.materiel,mt.id,s_s.materiel_id
--groupe 
--select*from stock_site

select  s.lieu,p.paf,p.id , 
	(( 
		select count(sss.*) from stock_site sss
		where sss.materiel_id =ss.materiel_id and sss.debut_serie is not null and sss.paf_id= p.id
		group by  sss.paf_id 
	)*500)-sum(ss.consommation)  from paf p
join site s on (s.id = p.site_id )
join stock_site ss on (ss.paf_id = p.id)
group by s.lieu,p.paf,ss.materiel_id,p.id;





select  s.lieu,m.materiel ,p.paf,p.id , 
	(( 
		select count(sss.*) from stock_site sss
		where sss.materiel_id =ss.materiel_id and sss.debut_serie is not null and sss.paf_id= p.id
		group by  sss.paf_id 
	)*500)-sum(ss.consommation),
(select sum(sss.entree) - sum(sss.consommation) from stock_site sss where sss.materiel_id=m.id )  from paf p
join site s on (s.id = p.site_id )
join stock_site ss on (ss.paf_id = p.id)
full join materiel m on (m.id = ss.materiel_id)
group by s.lieu,p.paf,ss.materiel_id,p.id,m.id




----- Etat Carton A 4 -----
select 
	mt.materiel,
	ste.lieu,
	sum((case when s_s.entree is null then 0 else s_s.entree end))*100
			-
	sum((case when s_s.consommation = 0 then 1 else 0 end))as état
from materiel mt
	join stock_site s_s on (s_s.materiel_id = mt.id)
	join site ste on (ste.id = s_s.site_id)
where mt.id =41
group by mt.materiel,ste.lieu


select 
	mt.materiel,
	ste.lieu,
case  when
				(sum(case when s_s.entree is null then 0 else s_s.entree end)*100 
						-
				sum(case when s_s.consommation = 0 then 1 else 0 end)) != 0 
		
					then 	
		
						sum((case when s_s.entree is null then 0 else s_s.entree end))*100 
								-
						sum((case when s_s.consommation = 0 then 1 else 0 end))
			else  
			(select entree  from stock_site s where  s.rapport_id is null and s.materiel_id = 41 
			and s.date_stock in (select max(ll.date_stock) from stock_site ll))  
	end  as état
from materiel mt
	join stock_site s_s on (s_s.materiel_id = mt.id)
	join site ste on (ste.id = s_s.site_id)
where mt.id =41
group by mt.materiel,ste.lieu


---
select 	
			case when ste.lieu is null then st_p.lieu
					else ste.lieu
			end sita,
			case when ste.id is null then st_p.id
					else ste.id
			end sita_id,
			mt.materiel,
			pf.paf,
			case when sum(s_s.fin_serie-s_s.debut_serie+1) is null then 0 else sum(s_s.fin_serie-s_s.debut_serie+1) end 
								 -
			case when sum(s_s.consommation) is null then 0 else sum(s_s.consommation) end
			 as etat
 from materiel mt
full join stock_site s_s on (s_s.materiel_id = mt.id)
left join site ste on (ste.id = s_s.site_id)
left join paf pf on (pf.id=s_s.paf_id)
left join site st_p on (st_p.id = pf.site_id)
group by sita,mt.materiel,pf.paf,sita_id




sum((case when s_s.entree is null then 0 else s_s.entree end))
						-
sum((case when s_s.consommation is null then 0 else  s_s.consommation end))as état

---------


select 	
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
									sum(case when s_s.consommation = 0 then 1 else 0 end)) != 0 
										then 	
											sum((case when s_s.entree is null then 0 else s_s.entree end))*100 	-
											sum((case when s_s.consommation = 0 then 1 else 0 end))
								else  
								(select entree  from stock_site s where  s.rapport_id is null and s.materiel_id = 41 
								and s.date_stock in (select max(ll.date_stock) from stock_site ll))  
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
group by sita,mt.materiel,pf.paf,sita_id,mt.id

having case when ste.id is null then st_p.id else ste.id end =1

--select * from stock_site where paf_id = 6
--select*from paf
--     select*from materiel
 
 ---- Modification -------
				select 	
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

						having case when ste.id is null then st_s.id else ste.id end =1


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