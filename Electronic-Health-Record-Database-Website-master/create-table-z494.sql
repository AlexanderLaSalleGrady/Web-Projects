SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS _doctor;
CREATE TABLE _doctor (
	id INT(3) AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(10) NOT NULL UNIQUE,
	password VARCHAR(10) NOT NULL,
	first_name VARCHAR(20) NOT NULL,
	last_name VARCHAR(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _patient;
CREATE TABLE _patient (
	id INT(5) AUTO_INCREMENT PRIMARY KEY,
	ssn CHAR(11) NOT NULL UNIQUE,
	first_name VARCHAR(20) NOT NULL,
	last_name VARCHAR(20) NOT NULL,
	date_of_birth DATE NOT NULL,
	sex CHAR(1) NOT NULL,
	address VARCHAR(20) NOT NULL,
	city VARCHAR(20) NOT NULL,
	state CHAR(2) NOT NULL,
	zip_code CHAR(5) NOT NULL,
	phone CHAR(12) NOT NULL,
	doctor_id INT(3) NOT NULL,
	FOREIGN KEY (doctor_id) REFERENCES _doctor(id) 
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _disease;
CREATE TABLE _disease (
	id INT(3) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _drug;
CREATE TABLE _drug (
	id INT(3) AUTO_INCREMENT PRIMARY KEY,
	trade_name VARCHAR(20) NOT NULL UNIQUE,
	generic_name VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _has_disease;
CREATE TABLE _has_disease (
	patient_id INT(5) NOT NULL,
	disease_id INT(3) NOT NULL,
	diagnosis_date DATE NOT NULL,
	PRIMARY KEY (patient_id, disease_id),
	FOREIGN KEY (patient_id) REFERENCES _patient(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (disease_id) REFERENCES _disease(id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _is_on_drug;
CREATE TABLE _is_on_drug (
	patient_id INT(5) NOT NULL,
	drug_id INT(3) NOT NULL,
	start_date DATE NOT NULL,
	PRIMARY KEY (patient_id, drug_id),
	FOREIGN KEY (patient_id) REFERENCES _patient(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (drug_id) REFERENCES _drug(id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO _doctor (id,username,password,first_name,last_name) VALUES 
('101','aaaa','AAaa12345','Aaron','Arnold'),
('102','zzzz','ZZzz67890','Zachary','Zeigler');

INSERT INTO _patient (id,ssn,first_name,last_name,date_of_birth,sex,address,city,state,zip_code,phone,doctor_id) VALUES 
('10002','181-48-1564','Bonnie','Brown','1962-11-18','F','1452 Cedar Road','New York','NY','10001','175-925-4788','101'),
('10003','873-43-8922','Caryn','Collins','1940-09-15','F','845 Oak Street','Chicago','IL','60018','682-283-0516','101'),
('10004','469-21-4510','Davis','Duncan','1954-03-11','M','1244 Bartlett Avenue','Washington','DC','20001','704-307-7846','101'),
('10005','989-74-8374','Evelyn','Edwards','1975-08-03','F','4731 Center Street','Atlanta','GA','30032','406-045-8399','101'),
('10006','697-99-3850','Frank','Fisher','1969-06-07','M','1122 Maple Lane','Philadelphia','PA','19102','833-398-9613','101'),
('10007','118-10-9931','George','Grant','1967-08-05','M','4809 Thompson Drive','Phoenix','AZ','85005','637-929-8615','101'),
('10008','171-42-2226','Harry','Harris','1969-12-05','M','1104 Conaway Street','San Antonio','TX','78202','589-932-1389','101'),
('10009','987-52-5459','Isabella','Ingram','1978-03-07','F','1134 Parkview Road','Houston','TX','77005','192-121-0010','101'),
('10010','901-97-0105','Jason','Jones','1961-02-02','M','1971 Pastures Drive','San Diego','CA','92093','845-031-0304','101'),
('10011','934-58-7655','Kim','Kent','1956-07-30','F','3271 Pine Drive','Dallas','TX','75201','558-069-0342','101'),
('10012','244-64-4570','Linda','Lewis','1948-01-18','F','976 Burke Street','San Jose','CA','95101','915-851-1975','101'),
('10013','589-42-4656','Michael','Murphy','1968-02-09','M','1370 Hill Drive','Austin','TX','73301','505-695-9739','101'),
('10014','759-67-7114','Natalie','Nelson','1971-11-03','F','2738 Davidson Street','Indianapolis','IN','46201','368-079-5680','102'),
('10015','822-98-9619','Owen','Oliver','1949-07-03','M','511 Forest Drive','Los Angeles','CA','90003','156-019-3589','102'),
('10016','287-80-1345','Pamela','Parker','1977-06-05','F','2103 Longview Avenue','Jacksonville','FL','32099','188-985-0888','102'),
('10017','728-57-9310','Quentin','Quinn','1960-08-09','M','656 Park Drive','San Francisco','CA','94101','617-548-5556','102'),
('10018','776-98-4827','Rebecca','Roberts','1943-02-24','F','4127 Wood Avenue','Columbus','OH','43085','229-133-5507','102'),
('10019','152-44-1860','Sarah','Scott','1978-07-02','F','2272 Augusta Avenue','Charlotte','NC','28078','751-948-6805','102'),
('10020','382-52-4970','Theresa','Thomas','1949-05-10','F','4521 Brownton Road','Fort Worth','TX','76052','378-156-6758','102'),
('10021','562-11-4114','Ulysses','Underwood','1974-12-20','M','2261 Chase Lane','Nashville','TN','37115','718-007-8896','102'),
('10022','702-19-2717','Vivian','Vincent','1968-09-14','F','3548 Pallet Street','Seattle','WA','98101','448-945-9056','102'),
('10023','667-12-7594','William','Wood','1950-01-09','M','3623 Lake Road','Portland','OR','97201','457-086-2471','102'),
('10024','163-13-2135','Xavier','Xander','1962-04-11','M','2756 Sherman Street','Denver','CO','80123','806-765-7137','102'),
('10025','857-26-9252','Yvonne','Young','1964-10-22','F','2568 Nutter Street','Milwaukee','WI','53211','629-840-3198','102');

INSERT INTO _disease (id,name) VALUES 
('101','Anemia'),
('102','Arthritis'),
('103','Asthma'),
('104','Atherosclerosis'),
('105','Bronchitis'),
('106','Cancer'),
('107','Colitis'),
('108','Conjunctivitis'),
('109','Depression'),
('110','Dermatitis'),
('111','Dyslexia'),
('112','Diabetes'),
('113','Hepatitis'),
('114','Hypertension'),
('115','Hypotension'),
('116','Obesity'),
('117','Osteoporosis'),
('118','Otitis'),
('119','Psoriasis'),
('120','Rheumatism'),
('121','Vitiligo');

INSERT INTO _drug (id,trade_name,generic_name) VALUES 
('101','NovaFerrum','Ferrous Sulfate'),
('102','Maxaron','Iron Glycinate Sulfate'),
('103','Celebrex','Celecoxib'),
('104','Plaquenil','Hydroxychloroquine'),
('105','Flovent Diskus','Fluticasone'),
('106','Alvesco','Ciclesonide'),
('107','Zetia','Ezetimibe'),
('108','Gemfibrozil','Fibrates'),
('109','Medrol','Methylprednisolone'),
('110','Orapred','Prednisolone Sodium'),
('111','Adriamycin','Doxorubicin'),
('112','Ellence','Epirubicin'),
('113','Apriso','Mesalamine'),
('114','Colazal','Balsalazide'),
('115','Vigamox','Moxifloxacin'),
('116','Zymaxid','Gatifloxacin'),
('117','Norpramin','Desipramine HCl'),
('118','Tofranil','Imipramine'),
('119','Zyrtec','Cetirizine'),
('120','Cortef','Hydrocortisone'),
('121','Antivert','Meclizine'),
('122','Ritalin','Methylphenidate'),
('123','Humalog','Insulin'),
('124','Glucophage','Metformin'),
('125','Pegasys','Peginterferon alfa-2a'),
('126','Virazole','Ribavirin'),
('127','Bumex','Bumetanide'),
('128','Dyrenium','Triamterene'),
('129','Orvaten','Midodrine'),
('130','Levophed','Norepinephrine'),
('131','Belviq','Lorcaserin'),
('132','Symlin','Pramlintide'),
('133','Boniva','Ibandronate Sodium'),
('134','Reclast','Zoledronic Acid'),
('135','Moxatag','Amoxicillin'),
('136','Zithromax','Azithromycin'),
('137','Elocon','Mometasone'),
('138','Neoral','Cyclosporine'),
('139','Arava','Leflunomide'),
('140','Voltaren','Diclofenac Sodium'),
('141','Uvadex','Methoxsalen'),
('142','Dovonex','Calcipotriol');

INSERT INTO _has_disease (patient_id,disease_id,diagnosis_date) VALUES 
('10002','104','2005-02-07'),
('10002','112','2005-08-26'),
('10002','114','2007-07-31'),
('10002','116','2006-01-03'),
('10003','109','2009-11-16'),
('10004','108','2003-10-08'),
('10004','118','2008-06-12'),
('10005','110','2008-06-19'),
('10005','119','2005-02-16'),
('10005','120','2012-12-19'),
('10005','121','2010-06-25'),
('10006','107','2003-08-26'),
('10006','113','2003-01-24'),
('10007','103','2006-09-06'),
('10008','117','2008-07-31'),
('10009','105','2010-09-28'),
('10010','102','2004-10-28'),
('10010','110','2006-04-21'),
('10010','120','2007-06-14'),
('10011','106','2004-04-03'),
('10012','101','2011-09-05'),
('10013','109','2008-03-27'),
('10013','111','2012-07-25'),
('10014','105','2003-05-22'),
('10015','107','2011-05-06'),
('10016','113','2007-09-25'),
('10017','112','2008-09-05'),
('10017','116','2011-05-27'),
('10018','120','2009-05-08'),
('10019','106','2005-11-14'),
('10020','104','2004-01-01'),
('10020','114','2009-10-20'),
('10021','101','2010-03-02'),
('10022','103','2009-10-02'),
('10022','105','2010-06-02'),
('10023','112','2008-04-22'),
('10024','107','2007-04-25'),
('10025','120','2002-11-18');

INSERT INTO _is_on_drug (patient_id,drug_id,start_date) VALUES 
('10002','108','2014-06-12'),
('10002','123','2014-06-13'),
('10002','131','2014-07-11'),
('10002','132','2013-11-29'),
('10003','117','2013-12-10'),
('10004','116','2013-12-26'),
('10004','135','2014-01-17'),
('10004','136','2014-01-10'),
('10005','119','2014-03-17'),
('10005','120','2014-04-15'),
('10005','142','2014-04-18'),
('10006','113','2014-04-30'),
('10006','126','2014-05-02'),
('10007','106','2014-05-05'),
('10008','133','2014-06-04'),
('10009','109','2013-10-18'),
('10009','110','2013-11-05'),
('10010','104','2013-11-15'),
('10010','119','2013-07-11'),
('10010','120','2013-08-12'),
('10010','140','2014-06-20'),
('10011','111','2013-09-01'),
('10011','112','2013-09-02'),
('10012','101','2013-10-24'),
('10013','118','2013-10-29'),
('10013','121','2013-11-12'),
('10013','122','2013-11-12'),
('10014','109','2013-08-22'),
('10015','113','2013-09-13'),
('10015','114','2013-09-14'),
('10016','126','2013-10-07'),
('10017','123','2013-09-18'),
('10017','132','2013-10-22'),
('10018','139','2013-11-11'),
('10019','111','2013-11-21'),
('10020','107','2013-11-25'),
('10020','127','2013-12-03'),
('10021','102','2013-12-23'),
('10022','105','2013-09-23'),
('10022','110','2013-09-24'),
('10023','124','2013-09-25'),
('10024','113','2013-08-09'),
('10024','114','2013-08-09'),
('10025','139','2013-10-24'),
('10025','140','2013-10-27');

SET FOREIGN_KEY_CHECKS = 1;