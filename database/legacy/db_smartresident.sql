CREATE DATABASE IF NOT EXISTS smartresident_v2;
USE smartresident_v2;

DROP TABLE IF EXISTS laporan_v2;
DROP TABLE IF EXISTS warga_v2;
DROP TABLE IF EXISTS admins_v2;

CREATE TABLE warga_v2 (
  id_warga int(11) NOT NULL AUTO_INCREMENT,
  nama varchar(100) NOT NULL,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id_warga),
  UNIQUE KEY username (username)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE admins_v2 (
  id_admin int(11) NOT NULL AUTO_INCREMENT,
  nama varchar(100) NOT NULL,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  role enum('admin','superadmin','kontraktor') NOT NULL,
  PRIMARY KEY (id_admin),
  UNIQUE KEY username (username)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE laporan_v2 (
  id_laporan int(11) NOT NULL AUTO_INCREMENT,
  id_warga int(11) NOT NULL,
  tipe_fasilitas varchar(50) NOT NULL,
  lokasi varchar(150) NOT NULL,
  deskripsi text DEFAULT NULL,
  status varchar(20) DEFAULT 'Menunggu',
  tanggal_lapor datetime DEFAULT current_timestamp(),
  id_kontraktor int(11) DEFAULT NULL,
  PRIMARY KEY (id_laporan),
  KEY id_warga (id_warga),
  KEY id_kontraktor (id_kontraktor),
  CONSTRAINT laporan_v2_ibfk_1 FOREIGN KEY (id_warga) REFERENCES warga_v2 (id_warga) ON DELETE CASCADE,
  CONSTRAINT fk_laporan_kontraktor FOREIGN KEY (id_kontraktor) REFERENCES admins_v2 (id_admin) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO warga_v2 VALUES 
(1,'Andika Ramadhan','andika','warga123'),
(2,'Rania Renata','rania','warga123'),
(3,'Muhammad Fadhil','fadhil','warga123');

INSERT INTO admins_v2 VALUES 
(1,'Rousyan Fikr (Admin)','admin','admin123','admin'),
(2,'Kepala Desa Citeureup (Super)','super','super123','superadmin'),
(3,'PT Semen Jaya (Kontraktor)','kontraktor','vendor123','kontraktor');

INSERT INTO laporan_v2 VALUES 
(1,1,'Jalan Raya','RT 05 RW 02, Dekat Masjid Al-Ikhlas','Jalan berlubang cukup dalam sekitar 15 cm, membahayakan pengendara motor.','Diproses','2026-06-08 17:17:58',3),
(2,2,'Penerangan Jalan','Gang Mawar 3, RT 01','Lampu PJU mati sejak 3 hari yang lalu, jalanan gelap gulita di malam hari.','Diproses','2026-06-08 17:17:58',3),
(3,3,'Saluran Air','Dusun Citeureup Selatan','Saluran air tersumbat sampah plastik menyebabkan genangan saat hujan deras.','Selesai','2026-06-08 17:17:58',3);
