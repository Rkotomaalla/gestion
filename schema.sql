CREATE DATABASE jus;
USE jus;

-- creation type de charge_repartition
CREATE TABLE type_charge(
id_type_charge INT PRIMARY KEY auto_increment,
nom_type_charge VARCHAR(255) not null
);

-- creatio table nature(fixe ou variable)
CREATE TABLE nature(
    id_nature INT PRIMARY KEY auto_increment,
    nom_nature VARCHAR(255) not null
);

--CREATION TABLE unite_oeuvre
CREATE TABLE unite_oeuvre(
    id_unite_oeuvre INT PRIMARY KEY auto_increment,
    nom_unite_oeuvre VARCHAR(255) not null,
    abreviation VARCHAR(50) not null
);



-- CREATION TABLE Rubrique
CREATE TABLE rubrique(
    id_rubrique INT PRIMARY KEY auto_increment,
    nom_rubrique VARCHAR(255) not null,
    id_unite_oeuvre INT not null
);
ALTER TABLE rubrique ADD FOREIGN KEY (id_unite_oeuvre) REFERENCES unite_oeuvre(id_unite_oeuvre); 

CREATE TABLE charge(
    id_charge INT PRIMARY KEY auto_increment,
    id_nature INT not null,
    id_rubrique INT not null,
    id_type INT not null,
    unite DECIMAL(15,5)not null,
    montant DECIMAL(15,2) not null,
    date_charge DATE not null
);
ALTER TABLE charge ADD FOREIGN KEY (id_nature) REFERENCES nature(id_nature); 
ALTER TABLE charge ADD FOREIGN KEY (id_rubrique) REFERENCES rubrique(id_rubrique); 
ALTER TABLE charge ADD FOREIGN KEY (id_type) REFERENCES type_charge(id_type_charge);

CREATE TABLE repartition(
    id_repartition INT PRIMARY KEY auto_increment,
    nom_repartition VARCHAR(255) not null
);



CREATE TABLE charge_repartition(
    id_charge_repartition INT PRIMARY KEY auto_increment,
    id_charge INT not null,
    id_repartition INT not null,
    taux DECIMAL(15,3)
);
ALTER TABLE charge_repartition ADD FOREIGN KEY (id_charge) REFERENCES charge(id_charge); 
ALTER TABLE charge_repartition ADD FOREIGN KEY (id_repartition) REFERENCES repartition(id_repartition); 


INSERT INTO type_charge (id_type_charge,nom_type_charge) VALUES 
            (null,"corporable"),
            (null,"non corporable"),
            (null,"suppletive");

INSERT INTO nature (id_nature,nom_nature) VALUES (null,"Variable"),
                                                                                                               (null,"Fixe");

INSERT INTO unite_oeuvre (nom_unite_oeuvre, abreviation)
VALUES
('Kilogramme', 'kg'),
('Litre', 'L'),
('Pièce', 'pc'),
('Mètre', 'm'),
('Heure', 'h'),
('Jour', 'j'),
('Kilowatt', 'kW'),
('Mètre cube', 'm³'),
('Tonne', 't'),
('Gramme', 'g'),
('Centimètre', 'cm'),
('Millilitre', 'ml'),
('Unité', 'u'),
('Boîte', 'bte'),
('Paquet', 'pkt');

INSERT INTO repartition VALUES (null,"Matiere Première"),
                                                                    (null,"transformation"),
                                                                    (null,"administration"),
                                                                    (null,"distribution"),
                                                                    (null,"magasin");

SELECT rubrique.*  FROM rubrique JOIN unite_oeuvre on rubrique.id_unite_oeuvre=unite_oeuvre.id_unite_oeuvre;
SELECT * FROM rubrique JOIN charge ON rubrique.id_rubrique=charge.id_rubrique; 



CREATE OR REPLACE VIEW v_rubrique AS
SELECT rubrique.id_rubrique as id_r,
                rubrique.nom_rubrique as nom_r,
                unite_oeuvre.nom_unite_oeuvre as nom_u,
                unite_oeuvre.abreviation as abreviation_u
FROM 
                rubrique
JOIN 
                unite_oeuvre
ON 
                rubrique.id_unite_oeuvre=unite_oeuvre.id_unite_oeuvre;




SELECT 
    charge.*,
    nature.nom_nature 
FROM 
    charge
JOIN 
    nature
ON 
    charge.id_nature=nature.id_nature;




CREATE OR REPLACE
VIEW    
    charge_1 
AS SELECT 
    charge.*,
    nature.nom_nature 
FROM 
    charge
JOIN 
    nature
ON 
    charge.id_nature=nature.id_nature;


CREATE or REPLACE VIEW charge_2 AS
SELECT 
    charge_1.*,
    type_charge.nom_type_charge 
FROM 
    charge_1 
JOIN
    type_charge
ON
    charge_1.id_type=type_charge.id_type_charge;


    CREATE OR REPLACE VIEW charge_3 AS
    SELECT 
        charge_2.*,
        v_rubrique.nom_r as rubrique,
        v_rubrique.nom_u as unite_oeuvre,
        v_rubrique.abreviation_u as abreviation_unite_oeuvre
    FROM 
        charge_2
    JOIN 
        v_rubrique
    ON 
        charge_2.id_rubrique=v_rubrique.id_r;


CREATE OR REPLACE VIEW charge_4 AS
        SELECT 
            charge_3.*,
            charge_repartition.id_charge_repartition,
            charge_repartition.id_repartition,
            taux
        FROM
            charge_3
        JOIN
            charge_repartition
        ON
            charge_3.id_charge=charge_repartition.id_charge;

CREATE OR REPLACE VIEW v_depense AS
SELECT charge_4.* , nom_repartition FROM charge_4 JOIN repartition ON repartition.id_repartition=charge_4.id_repartition; 






SELECT 
    id_charge,
    rubrique,
    unite_oeuvre,
    montant,
    nom_nature,
    nom_type_charge,
    unite

FROM 
    v_depense
GROUP BY id_charge;

CREATE OR REPLACE view v_repartition as 
SELECT 
    id_charge,
    MAX(CASE WHEN repartition.nom_repartition = 'Matiere Premiere' THEN taux ELSE 0 END) AS 'Matiere_Premiere',
    MAX(CASE WHEN repartition.nom_repartition = 'transformation' THEN taux ELSE 0 END) AS 'transformation',
    MAX(CASE WHEN repartition.nom_repartition = 'administration' THEN taux ELSE 0 END) AS 'administration',
    MAX(CASE WHEN repartition.nom_repartition = 'distribution' THEN taux ELSE 0 END) AS 'distribution',
    MAX(CASE WHEN repartition.nom_repartition = 'magasin' THEN taux ELSE 0 END) AS 'magasin'
FROM 
    charge_repartition 
JOIN 
    repartition ON charge_repartition.id_repartition = repartition.id_repartition
GROUP BY 
    id_charge;

CREATE OR REPLACE VIEW v_all_charge AS
select 
    charge_3.*,
    v_repartition.Matiere_Premiere,
    v_repartition.transformation,
    v_repartition.administration,
    v_repartition.distribution,
    v_repartition.magasin 
from 
    charge_3 
JOIN 
    v_repartition 
ON 
    charge_3.id_charge=v_repartition.id_charge;

CREATE OR Replace VIEW v_total as  
SELECT 
    id_nature,
    nom_nature,
    SUM(montant) as montant,
    SUM((Matiere_Premiere*montant)/100) as t_Matiere_premiere,
    SUM((transformation*montant)/100) as t_transformation ,
    SUM((administration*montant)/100) as t_administration ,
    SUM((distribution*montant)/100) as t_distribution,
    SUM((magasin*montant)/100) as t_magasin
FROM 
    v_all_charge
GROUP BY id_nature;


CREATE OR Replace VIEW v_total_join as  
SELECT 
    n.id_nature,
    n.nom_nature,
    IFNULL(v.montant, 0) AS montant,
    IFNULL(v.t_Matiere_premiere, 0) AS t_Matiere_premiere,
    IFNULL(v.t_transformation, 0) AS t_transformation,
    IFNULL(v.t_administration, 0) AS t_administration,
    IFNULL(v.t_distribution, 0) AS t_distribution,
    IFNULL(v.t_magasin, 0) AS t_magasin
FROM 
    nature n
LEFT JOIN 
    v_total v ON n.id_nature = v.id_nature;


CREATE OR REPLACE VIEW total_nature AS
SELECT 
    n.id_nature,
    n.nom_nature,
    IFNULL(
        SUM(
            IFNULL(v.t_Matiere_premiere, 0) +
            IFNULL(v.t_transformation, 0) +
            IFNULL(v.t_administration, 0) +
            IFNULL(v.t_distribution, 0) +
            IFNULL(v.t_magasin, 0)
        ), 0
    ) AS total
FROM 
    nature n
LEFT JOIN 
    v_total v ON n.id_nature = v.id_nature
GROUP BY 
    n.id_nature;


create or replace view total_repart
select 
    SUM(t_Matiere_Premiere) as s_matiere_premiere,
    SUM(t_transformation) as s_transformation,
    SUM(t_administration) as s_administration,
    SUM(t_distribution) as s_distribution,
     SUM(t_magasin) as s_magasin 
from 
    v_total;


CREATE OR REPLACE VIEW total_nature
AS
SELECT 
     id_nature,
     nom_nature,
    SUM(t_Matiere_Premiere+t_transformation+t_administration+t_distribution+t_magasin) as total 
FROM 
    v_total;