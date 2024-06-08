create database construction;
\c construction

create database construction2;
\c construction2

create table poste(
    id varchar(100) primary key,
    nom varchar(100) not null
);

create table employe(
    id varchar(100) primary key ,
    nom varchar(200) not null,
    prenom varchar(200) not null,
    contact INTEGER CHECK (contact = 10),
    email varchar(100) not null,
    idposte varchar(100) references poste(id)
);

create table typeTravaux(
    id serial primary key ,
    code varchar(100) not null,
    nom varchar(300)
);

-- inserte type travaux
insert into typeTravaux values (default,'000','TRAVAUX PREPARATOIR');
insert into typeTravaux values (default,'100','TRAVAUX DE TERRASSEMENT');
insert into typeTravaux values (default,'200','TRAVAUX EN INFRASTRUCTURE');
insert into typeTravaux values (default,'300','TRAVAUX EN 300');
insert into typeTravaux values (default,'400','TRAVAUX EN 44');

create table unite(
    id serial primary key,
    nom varchar(50)
);

insert into unite values (default,'m2');
insert into unite values (default,'m3');
insert into unite values (default,'fft');
insert into unite values (default,'kg');

create table sousTravaux(
    id serial primary key ,
    idTypeTravaux int references typeTravaux(id),
    code varchar(100) not null,
    nom varchar(300) not null,
    id_unite int references unite(id),
    quantite double precision,
    prix numeric(50,2)
);
ALTER TABLE sousTravaux
    RENAME COLUMN quantie TO quantite;


-- inserte donnee


-- INSERT SOUT TRAVAUX
insert into sousTravaux values(default, 1,'001', 'Mur de soutenement',2,1,190000.00);

insert into sousTravaux values(default, 2,'101', 'Decapage des terrains meubles',1,1,3072.87);
insert into sousTravaux values(default, 2,'102', 'Dressage du plateforme',1,1,3736.26);
insert into sousTravaux values(default, 2,'103', 'Fouille d ouvrage terrain ferme',2,1,9390.93 );
insert into sousTravaux values(default, 2,'104', 'Remblai d ouvrage',2,1,37563.26);
insert into sousTravaux values(default, 2,'105', 'Travaux d implantation', 3, 1,152656.00);

insert into sousTravaux values(default, 3,'201', 'Maçonnerie de mellons',3,1,172144.40);
insert into sousTravaux values(default, 3,'202', 'Beton armee',3,null,null);
insert into sousTravaux values(default, 3,'203', 'Remblai technique',3,1,37563.26);
insert into sousTravaux values(default, 3,'204', 'herrissonga ep =10', 3,1,73245.40);
insert into sousTravaux values(default, 3,'205', 'Beton ordinaire',3,1,487815.80);
insert into sousTravaux values(default, 3,'206', 'Chape de 2 cm',3,1,33566.54);

drop table ssTravaux;

create table ssTravaux(
    id serial primary key,
    idSousTravaux int references sousTravaux(id),
    nom varchar(300),
    id_unite varchar(100),
    quantite double precision,
    prix numeric(100,2)
);
-- INSERT SS TRAVAUX

insert into ssTravaux values (default,8,'semelles isolee',3,0.53,573215.80);
insert into ssTravaux values (default,8,'amorces poteaux',3,0.56,573215.80);
insert into ssTravaux values (default,8,'chainage bas 20',3,2.44,573215.80);

-- view get prix
create or replace view get_total_sstravaux as
SELECT
    ROUND(CAST(SUM(ssTravaux.quantite * ssTravaux.prix) AS NUMERIC(50,2)), 2) as total_prix,
    ssTravaux.idSousTravaux,
    ROUND(CAST(SUM(ssTravaux.quantite) as numeric(10,2)), 2) as quantite_final
FROM
    ssTravaux
        JOIN
    sousTravaux sT ON ssTravaux.idSousTravaux = sT.id
WHERE
    ssTravaux.idSousTravaux = sT.id
GROUP BY
    ssTravaux.idSousTravaux;


-- fonction mise a jour table sousTravaux
CREATE OR REPLACE FUNCTION update_travaux() RETURNS TEXT AS $$
DECLARE
    prix_v NUMERIC(50,2);
    id_T INTEGER;
    quantite_v numeric(10,2);
BEGIN

SELECT total_prix, idsoustravaux, quantite_final INTO  prix_v, id_T, quantite_v
FROM get_total_sstravaux;

UPDATE sousTravaux
SET prix =  prix_v ,quantite = quantite_v
WHERE id = id_T;

RETURN 'Mise à jour effectuée avec succès';
END;
$$ LANGUAGE plpgsql;
///////////////////


create table maison(
    id varchar(200) primary key,
    nom varchar(300) not null,
    description varchar(300),
    surface numeric(10,2)
);

-- inserte maison
INSERT INTO maison
SELECT maison_id(), 'villa base';


-- vao2
create table devisMasion(
    id serial primary key,
    idMasion varchar(300) references maison(id),
    ref_devis varchar(50),
    nom varchar(100),
    duree double precision,
    date_creation timestamp
);

insert into devisMasion values (default,'MS001','Maison Milay',45,'01-01-2000')

-- vao
create table detailDevis(
    id serial primary key ,
    idDevisMaison int references devisMasion(id),
    idST int references sousTravaux(id),
    quantite numeric(10,2),
    prix_unitaire numeric(10,2)
);

-- requete cacule somme
create view somme_detail as
select sum((d.quantite * d.prix_unitaire)/sT.quantite) as prix_total, sT.idTypeTravaux,
       d.idDevisMaison,d.idST,d.quantite,d.prix_unitaire,sT.id_unite, sT.nom, sT.code
from detailDevis as d join sousTravaux as sT on d.idST = sT.id
group by sT.idTypeTravaux,d.idDevisMaison,d.idST,d.quantite,d.prix_unitaire,sT.id_unite,sT.nom, sT.code ;

-- autre
select * from detailDevis as d join sousTravaux sT on d.idST = sT.id;

select sum((d.quantite * d.prix_unitaire)/sT.quantite) as prix_total, st.idTypeTravaux
from detailDevis as d join sousTravaux as sT on d.idST = sT.id
group by sT.idTypeTravaux;

create or replace view get_list_Devis as
select d.idDevisMaison,d.idST,d.quantite,d.prix_unitaire, sT.idTypeTravaux, sT.code, sT.nom,sT.id_unite
from detailDevis as d join sousTravaux as sT on d.idST = sT.id;

select *
from somme_detail where idtypetravaux = 1;

select *
from somme_detail where idtypetravaux = 2;

select *, sum(prix_total) as total
from somme_detail where idtypetravaux = 3;

create or replace view maison_devis as
select dm.*, m.nom as nom_maison
from devisMasion as dm join maison as m on dm.idMasion = m.id;

-- inserte donnee

INSERT INTO detailDevis
VALUES (DEFAULT, 1, 1,26.98,(SELECT prix FROM sousTravaux WHERE code = '001'));

INSERT INTO detailDevis
VALUES (DEFAULT, 1, 2,101.36, (SELECT prix FROM sousTravaux WHERE code = '101'));

INSERT INTO detailDevis
VALUES (DEFAULT, 1, 3,101.36, (SELECT prix FROM sousTravaux WHERE code = '102'));

INSERT INTO detailDevis
VALUES (DEFAULT, 1,4 ,24.44, (SELECT prix FROM sousTravaux WHERE code = '103'));

INSERT INTO detailDevis
VALUES (DEFAULT, 1, 5,15.59, (SELECT prix FROM sousTravaux WHERE code = '104'));

INSERT INTO detailDevis
VALUES (DEFAULT, 1, 6,1.00, (SELECT prix FROM sousTravaux WHERE code = '105'));

INSERT INTO detailDevis
VALUES (DEFAULT,1,7, 9.62, (SELECT prix FROM sousTravaux WHERE code = '201'));

INSERT INTO detailDevis
VALUES (DEFAULT,1, 8, 3.53, (SELECT prix FROM sousTravaux WHERE code = '202'));

INSERT INTO detailDevis
VALUES (DEFAULT,1, 9,15.59 , (SELECT prix FROM sousTravaux WHERE code = '203'));

INSERT INTO detailDevis
VALUES (DEFAULT,1, 10, 7.80, (SELECT prix FROM sousTravaux WHERE code = '204'));

INSERT INTO detailDevis
VALUES (DEFAULT,1, 11, 5.46, (SELECT prix FROM sousTravaux WHERE code = '205'));

INSERT INTO detailDevis
VALUES (DEFAULT,1, 12, 77.97, (SELECT prix FROM sousTravaux WHERE code = '206'));


-- insert devis


create table client(
    id serial primary key,
    nom varchar(200) not null,
    prenom varchar(200) not null,
    contact varchar(10) unique
);

-- inserte client
insert into client values (default,'Tokiniaina','Fenitra','0341234567');
insert into client values (default,'Andry','Toky','0349876543');
insert into client values (default,'Andry','Toky','0340590098');

create table finition(
    id serial primary key ,
    nom varchar(100),
    pourcentage integer
);

-- insert finiton
insert into finition values (default,'Standard',1);
insert into finition values (default,'Gold ',5);
insert into finition values (default,'Premium ',10);
insert into finition values (default,'VIP ',30);

UPDATE finition SET pourcentage = 0 WHERE id = 4;


create table devisEnCours(
    id serial primary key ,
    idDevis int references devisMasion(id),
    idClient int references client,
    idfinition int references finition(id),
    poucentage numeric(10,2),
    lieu varchar(100),
    dateDevis timestamp
);


-- insert devisEnCours
insert into devisEnCours values (default,1,1,4,'13-05-2024');

-- requete devisEnCours
select ld.*, d.idClient, d.dateDevis
from devisEnCours as d join get_list_Devis as ld on d.idDevis = ld.iddevismaison;

--
create or replace view get_list_Devis_Client as
select d.*, dM.id as id_devis , dM.idMasion, dM.nom, dM.duree, dM.date_creation,c2.nom as nom_client
from devisEnCours as d join devisMasion dM on d.idDevis = dM.id
join client c2 on d.idClient = c2.id;

-- get_detail_finition

create or replace view get_detail_finition as
select sd.*, dc.id as id_encours, dc.idClient, dc.idfinition,f.nom as finition, f.pourcentage, dc.dateDevis
from devisEnCours as dc join somme_detail as sd on dc.idDevis = sd.iddevismaison
join finition as f on dc.idfinition = f.id;

select * from get_detail_finition group by
-- SOMME DES DEVIS

create or replace view get_somme_devis as
select ROUND(CAST(SUM(prix_total)as numeric(50,2)), 2) as total_encours,id_encours, pourcentage, dateDevis
from get_detail_finition as df
group by df.id_encours, id_encours, pourcentage, dateDevis;

--somme en devis_en cours
create or replace view somme_encours as
SELECT SUM(sd.total_encours)+(SUM(sd.total_encours * de.poucentage)/100) AS total_prix, sd.id_encours
FROM get_somme_devis AS sd join devisencours as de on sd.id_encours = de.id
GROUP BY sd.id_encours;


-- GET STAT MOIS
create or replace view stat_mois as
SELECT DATE_TRUNC('month', sd.dateDevis) AS month, SUM(total_encours)+(SUM(total_encours * pourcentage)/100) AS total_prix
FROM get_somme_devis AS sd
GROUP BY DATE_TRUNC('month', sd.dateDevis)
ORDER BY month;

-- GET STAT ANNEE
create or replace view stat_annee as
SELECT
    DATE_TRUNC('year', DATE_TRUNC('month', sd.dateDevis)) AS year_month,
    SUM(total_encours)+(SUM(total_encours * pourcentage)/100) AS total_prix
FROM
    get_somme_devis AS sd
GROUP BY
    DATE_TRUNC('year', DATE_TRUNC('month', sd.dateDevis))
ORDER BY
    year_month;



create table paiement(
    id serial primary key ,
    idDevisEnCours int references devisEnCours(id),
    montant numeric(50,2),
    ref_paiement varchar(40),
    date timestamp
);
-- inserte paiement
insert into paiement values (default, 4,10000,'A4683', '2024-05-13 21:32:00');

-- paiement effectuer
create or replace view paiement_effectue as
SELECT
    se.id_encours,
    COALESCE(SUM(p.montant), 0) AS total_paiement
FROM
    paiement AS p
        RIGHT JOIN
    somme_encours AS se ON p.idDevisEnCours = se.id_encours
GROUP BY
    se.id_encours;

-- total Paiement
create view total_paiement as
select sum(total_paiement) as total_p from paiement_effectue;

-- pourcentage effectuer
create or replace view pourcentage_paiement as
select pe.id_encours, (pe.total_paiement * 100)/se.total_prix as pourcentage_paiement
from paiement_effectue as pe join somme_encours as se on pe.id_encours = se.id_encours
group by pe.id_encours, pe.total_paiement,se.total_prix;

-- suite
CREATE OR REPLACE VIEW paiement_effectue_et_pourcentage AS
SELECT
    se.id_encours,
    COALESCE(SUM(p.montant), 0) AS total_paiement,
    COALESCE((SUM(p.montant) * 100.0) / se.total_prix, 0) AS pourcentage_paiement,
    se.total_prix
FROM
    paiement AS p
        RIGHT JOIN
    somme_encours AS se ON p.idDevisEnCours = se.id_encours
GROUP BY
    se.id_encours, se.total_prix;

-- liste Devis _Admin
create or replace view Encour_Final as
select de.*, pep.*, f.nom as finition, d.nom as maison
from paiement_effectue_et_pourcentage as pep
    join devisEnCours as de on pep.id_encours = de.id
    join finition f on de.idfinition = f.id
    join devismasion d on de.iddevis = d.id;


-- sequence maison -- generate
create sequence maison_sequence start with 1 increment by 1;

create or replace function maison_id() RETURNS text as $$
DECLARE
next_id integer;
    type_text text;
BEGIN
    next_id := nextval('maison_sequence');
    type_text := 'MS' || lpad(next_id::text, 3, '0');
RETURN type_text;
END;
$$ LANGUAGE plpgsql;



-- sequence poste -- generate
create sequence poste_sequence start with 1 increment by 1;

create or replace function poste_id() RETURNS text as $$
DECLARE
next_id integer;
    type_text text;
BEGIN
    next_id := nextval('poste_sequence');
    type_text := 'POST' || lpad(next_id::text, 3, '0');
RETURN type_text;
END;
$$ LANGUAGE plpgsql;


-- sequence employe -- generate
create sequence employe_sequence start with 1 increment by 1;

create or replace function employe_id() RETURNS text as $$
DECLARE
next_id integer;
    type_text text;
BEGIN
    next_id := nextval('employe_sequence');
    type_text := 'EMP' || lpad(next_id::text, 3, '0');
RETURN type_text;
END;
$$ LANGUAGE plpgsql;
-- supprimer
truncate table poste;
-- supprimer
alter sequence poste_sequence RESTART with 1;

-- suppr donnee

DO $$
DECLARE
    tab text;
BEGIN
    FOR tab IN (SELECT tablename FROM  where )

--TABLE IMPORT

create table import_maison_travaux(
    id serial primary key,
    type_maison varchar(100),
    description varchar(100),
    surface numeric(10,2),
    code_travaux varchar(100),
    type_travaux varchar(100),
    unite varchar(100),
    prix_unitaire numeric(10,2),
    quantite numeric(10,2),
    duree_travaux double precision
);

create table import_devis(
    id serial primary key ,
    client varchar(100),
    ref_devis varchar(100),
    type_maison varchar(100),
    finition varchar(100),
    taux_finition numeric(10,2),
    date_devis date,
    date_debut date,
    lieu varchar(100)
);

create table import_paiement(
    id serial primary key ,
    ref_devis varchar(100),
    ref_paiement varchar(50),
    date_paiement date,
    montant numeric(10,2)
);


update import_devis set client = '0340590098' where id = 1;


CREATE OR REPLACE FUNCTION insert_detail_encours()
RETURNS VOID AS $$
DECLARE
recS RECORD;
finition_id INTEGER;
BEGIN
FOR recS IN SELECT DISTINCT ref_devis, taux_finition, client, lieu, date_debut, finition FROM import_devis LOOP
SELECT id INTO finition_id FROM finition WHERE nom ILIKE '%' || recS.finition || '%';

INSERT INTO devisencours (iddevis, idclient,idfinition, poucentage, lieu, datedevis)
VALUES ((SELECT id FROM devisMasion WHERE ref_devis = recS.ref_devis), (select id from client where contact = recS.client),
        finition_id,
        recS.taux_finition,
        recS.lieu,
        recS.date_debut);
END LOOP;
END;
$$ LANGUAGE plpgsql;

$$

SELECT code FROM typeTravaux WHERE code < '101' ORDER BY code DESC limit 1;

select id from unite where nom = 'kg';

-- inserte type_travaux


create view get_Dtt as
SELECT DISTINCT LPAD(code_travaux, 1, '0') AS nouveau_code
FROM import_maison_travaux;

CREATE OR REPLACE FUNCTION insert_tts()
    RETURNS VOID AS $$
DECLARE
    recS RECORD;
BEGIN
    FOR recS IN SELECT COALESCE(CAST(nouveau_code AS INTEGER), 0) * 100 as type FROM get_Dtt LOOP
            INSERT INTO typeTravaux(code,nom)
                VALUES (recS.type, 'nom');
END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_Client()
RETURNS VOID AS $$
DECLARE
recS RECORD;
BEGIN
FOR recS IN SELECT DISTINCT client FROM import_devis group by client LOOP
    INSERT INTO client (nom,prenom,contact)
            VALUES ('nom','prenom', recS.client);
END LOOP;
END;
$$ LANGUAGE plpgsql;

   select id from maison where nom = 'TOKYO';

insert into client values (default,'nom','prenom', '');

-- inserte Maison
CREATE OR REPLACE FUNCTION insert_maison()
RETURNS VOID AS $$
DECLARE
recS RECORD;
    maison_id_text TEXT;
BEGIN
FOR recS IN SELECT DISTINCT type_maison, description, surface FROM import_maison_travaux LOOP
SELECT maison_id() INTO maison_id_text;
INSERT INTO maison (id, nom, description, surface)
VALUES (maison_id_text, recS.type_maison, recS.description, recS.surface);
END LOOP;
END;
$$ LANGUAGE plpgsql;

-- insert devis
CREATE OR REPLACE FUNCTION insert_devis()
RETURNS VOID AS $$
DECLARE
recS RECORD;
    du RECORD;
BEGIN
FOR recS IN SELECT DISTINCT type_maison, ref_devis, date_devis FROM import_devis LOOP
    INSERT INTO devisMasion (idmasion, ref_devis, nom, date_creation)
            VALUES ((SELECT id FROM maison WHERE nom ILIKE '%' || recS.type_maison || '%'), recS.ref_devis, 'Home', recS.date_devis);
END LOOP;

END;
$$ LANGUAGE plpgsql;

-- update_insert_devis

CREATE OR REPLACE FUNCTION update_insert_devis()
    RETURNS VOID AS $$
DECLARE
    du RECORD;
BEGIN

    FOR du IN SELECT DISTINCT duree_travaux, type_maison FROM import_maison_travaux LOOP
            UPDATE devisMasion SET duree = du.duree_travaux
            WHERE ref_devis IN (SELECT ref_devis FROM import_devis WHERE type_maison ILIKE '%' || du.type_maison || '%');
        END LOOP;
END;
$$ LANGUAGE plpgsql;

-- inset detail_devis
CREATE OR REPLACE FUNCTION new_insert_devis()
    RETURNS VOID AS $$
DECLARE
    recS RECORD;
    recSS RECORD;
    devis_id INT;
    sst_id INT;
BEGIN
    FOR recS IN SELECT DISTINCT ref_devis, type_maison FROM import_devis LOOP
            SELECT id INTO devis_id FROM devisMasion WHERE ref_devis ILIKE '%' || recS.ref_devis || '%' LIMIT 1;

            IF devis_id IS NOT NULL THEN
                FOR recSS IN SELECT DISTINCT prix_unitaire, quantite, code_travaux FROM import_maison_travaux WHERE type_maison ILIKE '%' || recS.type_maison || '%' LOOP

                        SELECT id INTO sst_id FROM sousTravaux WHERE code = recSS.code_travaux;

                        INSERT INTO detailDevis (iddevismaison, idst, quantite, prix_unitaire)
                        VALUES (devis_id, sst_id, recSS.quantite, recSS.prix_unitaire);
                    END LOOP;
            END IF;
        END LOOP;
END;
$$ LANGUAGE plpgsql;


--    nn


-- inserte sous travaux

select id , code from typeTravaux where code > (SELECT DISTINCT LPAD(code_travaux, 1, '0')
    AS nouveau_code FROM import_maison_travaux where code_travaux = '303' ) order by code asc ;

CREATE OR REPLACE FUNCTION insert_sst()
    RETURNS VOID AS $$
DECLARE
    recS RECORD;
    tt_id INT;
    unites INT;
BEGIN
    FOR recS IN SELECT DISTINCT code_travaux,type_travaux ,unite, prix_unitaire
                FROM import_maison_travaux
                group by code_travaux,prix_unitaire,unite,type_travaux LOOP

    select id into tt_id from typeTravaux where code > (SELECT DISTINCT LPAD(code_travaux, 1, '0')
        AS nouveau_code FROM import_maison_travaux where code_travaux = recS.code_travaux ) order by code asc limit 1;
    select id into unites from unite where nom ILIKE '%' || recS.unite || '%' LIMIT 1;

            INSERT INTO soustravaux(idtypetravaux, code, nom, id_unite, quantite, prix)
            values( tt_id, recS.code_travaux, recS.type_travaux,unites, 1, recS.prix_unitaire);
    END LOOP;
END;
$$ LANGUAGE plpgsql;

-- insert Devis en cours
CREATE OR REPLACE FUNCTION insert_detail_encours()
RETURNS VOID AS $$
DECLARE
recS RECORD;
finition_id INTEGER;
BEGIN
FOR recS IN SELECT DISTINCT ref_devis, taux_finition, client, lieu, date_debut, finition FROM import_devis LOOP
SELECT id INTO finition_id FROM finition WHERE nom ILIKE '%' || recS.finition || '%';

INSERT INTO devisencours (iddevis, idclient,idfinition, poucentage, lieu, datedevis)
VALUES ((SELECT id FROM devisMasion WHERE ref_devis = recS.ref_devis), (select id from client where contact = recS.client),
        finition_id,
        recS.taux_finition,
        recS.lieu,
        recS.date_debut);
END LOOP;
END;
$$ LANGUAGE plpgsql;

-- insert finition
CREATE OR REPLACE FUNCTION insert_finition()
    RETURNS VOID AS $$
DECLARE
    recS RECORD;
BEGIN
    FOR recS IN SELECT DISTINCT taux_finition,finition FROM import_devis LOOP
            INSERT INTO finition (nom, pourcentage)
            VALUES (recS.finition, recS.taux_finition);
        END LOOP;
END;
$$ LANGUAGE plpgsql;


-- insert Paiement

CREATE OR REPLACE FUNCTION insert_paiement()
RETURNS VOID AS $$
DECLARE
recS RECORD;
BEGIN
FOR recS IN SELECT DISTINCT ref_devis, ref_paiement, date_paiement,montant FROM import_paiement LOOP

INSERT INTO paiement (iddevisencours,montant,ref_paiement,date)
VALUES ((select de.id from devisencours de join devisMasion as dm on dm.id = de.iddevis where dm.ref_devis = recS.ref_devis),
        recS.montant, recS.ref_paiement, recS.date_paiement);
END LOOP;
END;
$$ LANGUAGE plpgsql;


-- somme_import

CREATE OR REPLACE PROCEDURE somme_import()
LANGUAGE plpgsql
AS $$
BEGIN
    PERFORM insert_Client();
    PERFORM insert_finition();
    PERFORM insert_tts();
    PERFORM  insert_sst();
    PERFORM insert_maison();
    PERFORM insert_devis();
    PERFORM update_insert_devis();
    PERFORM new_insert_devis();
    PERFORM insert_detail_encours();
END;
$$;


-- appel
-- import
    CALL somme_import();

-- table
    CALL delete_all_table();



//////////////////////////////////////////////////////////////////////////////

create view paiemenet_somme as
select sum(montant) as total_p from paiement;


/////////////////////////////////////////////////////////////////////////////////
select de.id from devisencours de join devisMasion as dm on dm.id = de.iddevis where dm.ref_devis = 'D001';

update devisencours set idclient = 3 where id = 7;

//////////////////////////////////////

CREATE OR REPLACE PROCEDURE delete_all_table()
LANGUAGE plpgsql
AS $$
DECLARE
    _table_names TEXT[] := ARRAY['typetravaux','client', 'finition', 'soustravaux', 'sstravaux', 'maison', 'devismasion', 'detaildevis', 'devisencours', 'paiement', 'import_maison_travaux', 'import_devis', 'import_paiement'];
    _table_name TEXT;
BEGIN
    FOREACH _table_name IN ARRAY _table_names
        LOOP
            EXECUTE FORMAT('TRUNCATE TABLE %I CASCADE;', _table_name);
        END LOOP;


    create or replace view get_total_sstravaux as
    SELECT
        ROUND(CAST(SUM(ssTravaux.quantite * ssTravaux.prix) AS NUMERIC(50,2)), 2) as total_prix,
        ssTravaux.idSousTravaux,
        ROUND(CAST(SUM(ssTravaux.quantite) as numeric(10,2)), 2) as quantite_final
    FROM
        ssTravaux
            JOIN
        sousTravaux sT ON ssTravaux.idSousTravaux = sT.id
    WHERE
        ssTravaux.idSousTravaux = sT.id
    GROUP BY
        ssTravaux.idSousTravaux;


    create or replace view get_list_Devis as
    select d.idDevisMaison,d.idST,d.quantite,d.prix_unitaire, sT.idTypeTravaux, sT.code, sT.nom,sT.id_unite
    from detailDevis as d join sousTravaux as sT on d.idST = sT.id;

    create or replace view maison_devis as
    select dm.*, m.nom as nom_maison
    from devisMasion as dm join maison as m on dm.idMasion = m.id;

    create or replace view get_list_Devis_Client as
    select d.*, dM.id as id_devis , dM.idMasion, dM.nom, dM.duree, dM.date_creation,c2.nom as nom_client
    from devisEnCours as d join devisMasion dM on d.idDevis = dM.id
                           join client c2 on d.idClient = c2.id;

    create or replace view get_dd_maison as
    SELECT DISTINCT ON (idmasion) idmasion, id, ref_devis, nom, duree, date_creation
    FROM (
             SELECT idmasion, id, ref_devis, nom, duree, date_creation,
                    ROW_NUMBER() OVER(PARTITION BY idmasion ORDER BY id) AS rn
             FROM devisMasion
         ) tmp
    WHERE rn = 1;


-- get_detail_finition

    create or replace view get_detail_finition as
    select sd.*, dc.id as id_encours, dc.idClient, dc.idfinition,f.nom as finition, f.pourcentage, dc.dateDevis
    from devisEnCours as dc join somme_detail as sd on dc.idDevis = sd.iddevismaison
                            join finition as f on dc.idfinition = f.id;

-- SOMME DES DEVIS

    create or replace view get_somme_devis as
    select ROUND(CAST(SUM(prix_total)as numeric(50,2)), 2) as total_encours,id_encours, pourcentage, dateDevis
    from get_detail_finition as df
    group by df.id_encours, id_encours, pourcentage, dateDevis;

    --somme en devis_en cours
    create or replace view somme_encours as
    SELECT SUM(sd.total_encours)+(SUM(sd.total_encours * de.poucentage)/100) AS total_prix, sd.id_encours
    FROM get_somme_devis AS sd join devisencours as de on sd.id_encours = de.id
    GROUP BY sd.id_encours;


    -- GET STAT MOIS
    create or replace view stat_mois as
    SELECT DATE_TRUNC('month', sd.dateDevis) AS month, SUM(total_encours)+(SUM(total_encours * pourcentage)/100) AS total_prix
    FROM get_somme_devis AS sd
    GROUP BY DATE_TRUNC('month', sd.dateDevis)
    ORDER BY month;

    -- GET STAT ANNEE
    create or replace view stat_annee as
    SELECT
        DATE_TRUNC('year', DATE_TRUNC('month', sd.dateDevis)) AS year_month,
        SUM(total_encours)+(SUM(total_encours * pourcentage)/100) AS total_prix
    FROM
        get_somme_devis AS sd
    GROUP BY
        DATE_TRUNC('year', DATE_TRUNC('month', sd.dateDevis))
    ORDER BY
        year_month;

    create or replace view paiement_effectue as
    SELECT
        se.id_encours,
        COALESCE(SUM(p.montant), 0) AS total_paiement
    FROM
        paiement AS p
            RIGHT JOIN
        somme_encours AS se ON p.idDevisEnCours = se.id_encours
    GROUP BY
        se.id_encours;

    create or replace view pourcentage_paiement as
    select pe.id_encours, (pe.total_paiement * 100)/se.total_prix as pourcentage_paiement
    from paiement_effectue as pe join somme_encours as se on pe.id_encours = se.id_encours
    group by pe.id_encours, pe.total_paiement,se.total_prix;

    CREATE OR REPLACE VIEW paiement_effectue_et_pourcentage AS
    SELECT
        se.id_encours,
        COALESCE(SUM(p.montant), 0) AS total_paiement,
        COALESCE((SUM(p.montant) * 100.0) / se.total_prix, 0) AS pourcentage_paiement,
        se.total_prix
    FROM
        paiement AS p
            RIGHT JOIN
        somme_encours AS se ON p.idDevisEnCours = se.id_encours
    GROUP BY
        se.id_encours, se.total_prix;

    create or replace view Encour_Final as
    select de.*, pep.*, f.nom as finition, d.nom as maison
    from paiement_effectue_et_pourcentage as pep
             join devisEnCours as de on pep.id_encours = de.id
             join finition f on de.idfinition = f.id
             join devismasion d on de.iddevis = d.id;


    alter sequence poste_sequence RESTART with 1;
    alter sequence maison_sequence RESTART with 1;
    alter sequence employe_sequence RESTART with 1;

END;
$$;


