create table CLIENT (
  id_client        int(5) auto_increment,
  nama_cpw         varchar(60),
  nama_ortu_cpw    varchar(60),
  tlp_rumah_cpw    varchar(15),
  tlp_mobile_cpw   varchar(15),
  alamat_cpw       varchar(100),
  nama_cpp         varchar(60),
  nama_ortu_cpp    varchar(60),
  tlp_rumah_cpp    varchar(15),
  tlp_mobile_cpp   varchar(15),
  alamat_cpp       varchar(100),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client)
);

create table P_PRODUK (
  id_produk        int(3) auto_increment,
  produk           varchar(20),
  primary key (id_produk)
);

insert into p_produk values (1,'Sanggar Rias');
insert into p_produk values (2,'Photografi');
insert into p_produk values (3,'Butik');
insert into p_produk values (4,'Wedding Organizer');
insert into p_produk values (5,'Tenda');
insert into p_produk values (6,'Catering');


create table P_ACARA (
  id_acara        int(3) auto_increment,
  acara           varchar(20),
  page            varchar(30),
  primary key (id_acara)
);
insert into p_acara values (1,'Siraman', 'siraman');
insert into p_acara values (2,'Akad Nikah', 'akad');
insert into p_acara values (3,'Resepsi', 'resepsi');


create table P_GAYA (
  id_gaya          int(3) auto_increment,
  gaya             varchar(20),
  primary key (id_gaya)
);

insert into p_gaya values (1,'Sunda');
insert into p_gaya values (2,'Jawa');
insert into p_gaya values (3,'Solo');
insert into p_gaya values (4,'Jogja');
insert into p_gaya values (5,'Betawi');
insert into p_gaya values (6,'Lainnya');

/*--dihapus
create table ACARA (
  id_client        int(5),
  id_acara         int(3),
  id_gaya          int(3),
  id_paket         int(3),
  tanggal          date,
  waktu            varchar(8),
  tempat           varchar(100),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara)
);
*/

create table P_SUMBERDAYA (
  id_sumber        int(3) auto_increment,
  sumberdaya       varchar(20),
  primary key (id_sumber)
);
insert into p_sumberdaya values (1,'Material Sendiri');
insert into p_sumberdaya values (2,'Material Order');
insert into p_sumberdaya values (3,'Material Sewa');
insert into p_sumberdaya values (4,'SDM internal');
insert into p_sumberdaya values (5,'SDM outsource');


create table P_LAYANAN (
  id_layanan       int(3) auto_increment,
  layanan          varchar(50),
  scriptpage       varchar(30),
  primary key (id_layanan)
);
insert into p_layanan values (1,'Tata Rias','tatarias'); 
insert into p_layanan values (2,'Tata Busana','tatarias');
insert into p_layanan values (3,'Master of Ceremony',NULL);
insert into p_layanan values (4,'Sajen',NULL);
insert into p_layanan values (5,'Tarian',NULL);
insert into p_layanan values (6,'Upacara Adat',NULL);
insert into p_layanan values (7,'Bunga',NULL);
insert into p_layanan values (8,'Dekorasi',NULL);
insert into p_layanan values (9,'Lain - Lain',NULL);


create table P_JABATAN (
  id_jabatan      int(3) auto_increment,
  nama_jabatan    varchar(30),
  primary key (id_jabatan)
);
insert into P_JABATAN values (1,'Pengantin CPW&CPP');
insert into P_JABATAN values (2,'Keluarga Kandung');
insert into P_JABATAN values (3,'Keluarga & Saudara');
insert into P_JABATAN values (4,'Pagar Ayu&Bagus');
insert into P_JABATAN values (5,'Among Tamu Pria&Wanita');


create table PAKET (
  id_paket         int(3) auto_increment,
  nama_paket       varchar(50),
  harga_paket      int(5),
  uraian_paket     varchar(255),
  tgl_inisial      date,
  tgl_expire       date,
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_paket)
);

create table PAKET_ACARA (
  id_paket        int(3),
  id_acara        int(3)
);

create table PAKET_LAYANAN (
  id_paket         int(3),
  id_acara         int(3),
  id_layanan       int(3),
  id_tambah        int(3),
  tambahan	   varchar(255),
  catatan	   varchar(500),
  layanan          varchar(50),
  scriptpage       varchar(30),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime
);


create table PAKET_BUSANA (
  id_paket         int(3),
  id_acara         int(3),
  id_layanan       int(3),
  id_jabatan       int(3),
  wanitabaju       int(3),
  wanitakain       int(3),
  wanitaselop      int(3),
  wanitaasesoris   int(3),
  priabaju         int(3),
  priakain         int(3),
  priaselop        int(3),
  priaasesoris     int(3),
  priablangkon     int(3),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_paket,id_acara,id_layanan,id_jabatan)
);

create table PAKET_RIAS (
  id_paket         int(3),
  id_acara         int(3),
  id_layanan       int(3),
  id_jabatan       int(3),
  makeup_special   int(3),
  makeup_standart  int(3),
  sgljlb_special   int(3),
  sgljlb_standart  int(3),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_paket,id_acara,id_layanan,id_jabatan)
);

create table ORDER_ACARA (
  id_client        int(5),
  id_paket         int(3),
  id_acara         int(3),
  tanggal          date,
  waktu            varchar(8),
  tempat           varchar(100),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara)
);

create table ORDER_LAYANAN (
  id_client        int(5),
  id_paket         int(3),
  id_acara         int(3),
  id_layanan       int(3),
  layanan          varchar(50),
  scriptpage       varchar(30),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime
);

create table ORDER_TATABUSANA (
  id_client        int(5),
  id_paket         int(3),
  id_acara         int(3),
  id_layanan       int(3),
  id_jabatan       int(3),
  wanitabaju       int(3),
  wanitakain       int(3),
  wanitaselop      int(3),
  wanitaasesoris   int(3),
  priabaju         int(3),
  priakain         int(3),
  priaselop        int(3),
  priaasesoris     int(3),
  priablangkon     int(3),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_paket,id_acara,id_layanan,id_jabatan)
);


create table ORDER_TATARIAS (
  id_client        int(5),
  id_paket         int(3),
  id_acara         int(3),
  id_layanan       int(3),
  id_jabatan       int(3),
  makeup_special   int(3),
  makeup_standart  int(3),
  sgljlb_special   int(3),
  sgljlb_standart  int(3),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_paket,id_acara,id_layanan,id_jabatan)
);



create table P_SAJEN (
  id_sajen     int(5) auto_increment,
  nama         varchar(30),
  keterangan   varchar(255),
  foto         varchar(30),
  tarif        int(5),
  primary key (id_sajen)
);
insert into P_SAJEN values (1,'Sajen Tarub', 'Keterangan Sajen Tarub',NULL,99999);
insert into P_SAJEN values (2,'Sajen Langkahan', 'Keterangan Sajen Langkahan',NULL,99999);
insert into P_SAJEN values (3,'Sajen Buncalan', 'Keterangan Sajen Buncalan',NULL,99999);

create table ORDER_SAJEN (
  id_client        int(5),
  id_acara         int(3),
  id_sajen         int(3),
  id_pegawai       int(3),
  jumlah           int(3),
  harga_baru       int(5),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara,id_sajen)
);

create table P_MC (
  id_mc        int(5) auto_increment,
  nama         varchar(30),
  keterangan   varchar(255),
  foto         varchar(30),
  tarif        int(5),
  primary key (id_mc)
);
insert into P_MC values (1,'Priyo Jatmiko', 'Keterangan kecakapan dan spesifikasi keahlian yang dimiliki Jatmiko',NULL,99999);
insert into P_MC values (2,'Joko Kumolo Kolo', 'Keterangan kecakapan dan spesifikasi keahlian yang dimiliki Kumolo',NULL,99999);

create table ORDER_MC (
  id_client        int(5),
  id_acara         int(3),
  id_mc            int(3),
  harga_baru       int(5),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara,id_mc)
);


create table P_TARIAN (
  id_tarian    int(5) auto_increment,
  nama         varchar(30),
  keterangan   varchar(255),
  foto         varchar(30),
  tarif        int(5),
  jml_penari   int(5),
  primary key (id_tarian)
);
insert into P_TARIAN values (1,'Tarian Karonsih', 'Keterangan tarian Karonsih',NULL,99999,1);
insert into P_TARIAN values (2,'Tarian Gambyong', 'Keterangan tarian Gambyong',NULL,99999,1);
insert into P_TARIAN values (3,'Tarian Jaipong', 'Keterangan tarian Jaipong',NULL,99999,1);
insert into P_TARIAN values (4,'Tarian Merak', 'Keterangan tarian Merak',NULL,99999,1);
insert into P_TARIAN values (5,'Tarian Lengser', 'Keterangan tarian Lengser',NULL,99999,1);
insert into P_TARIAN values (6,'Tarian Payung', 'Keterangan tarian Payung',NULL,99999,1);

create table ORDER_TARIAN (
  id_client        int(5),
  id_acara         int(3),
  id_tarian        int(3),
  harga_baru       int(5),
  catatan	   varchar(100),
  jml_penari       int(5),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara,id_tarian)
);


create table P_ADAT (
  id_adat      int(5) auto_increment,
  nama         varchar(30),
  keterangan   varchar(255),
  foto         varchar(30),
  tarif        int(5),
  primary key (id_adat)
);
insert into P_ADAT values (1,'Upacara Ngeuyeuk Seureuh','a. MC Adat untuk Ngeuyeuk Seureuh\rb. Perlengkapan Lengkap : Mayang, Jambe, Sirih, Dll.',NULL,99999);
insert into P_ADAT values (2,'Upacara Sawer','a. MC Adat untuk Sawer\rb. 1 orang Juru Tembang\rc. Alat-Alat Sawer : Beras Kuning, Elekan & Kendi, Lidi Enau & telur\rd. Huap Lingkung : Bakakak Ayam & nasi Kuning\re. Burung Merpati 1 pasang',NULL,99999);
insert into P_ADAT values (3,'Paket Mapag Panganten I','a. 1 orang Lengser\rb. 1 orang pembawa Payung\rc. 2 orang pembawa Tombak\rd. 4 orang pembawa Umbul-Umbul\re. 4 orang penari Puja',NULL,99999);
insert into P_ADAT values (4,'Paket Mapag Panganten II','a. 1 orang Lengser\rb. 1 orang Ksatria\rc. 2 orang penari puja\rd. 1 orang pembawa Payung',NULL,99999);
insert into P_ADAT values (5,'Kecapi Suling [Tanpa Sound System]','a. 1 orang juru Kawih\rb. 1 orang pemain Suling\rc. 1 orang pemain kecapi rincik\rd. 1 orang pemain kecapi indung',NULL,99999);
insert into P_ADAT values (6,'Degung [tanpa sound sistem]','Keterangan Degung',NULL,99999);
insert into P_ADAT values (7,'Gamelan [tanpa sound sistem]','Keterangan Gamelan',NULL,99999);
insert into P_ADAT values (8,'Organ Tunggal [tanpa sound sistem]','a. Penyanyi 1 orang\rb. Pemain Organ 1 orang\rc. Sound System 1000 watt',NULL,99999);
insert into P_ADAT values (9,'Upacara Temon / Panggih','a. Sanggan, Cikal & Nasi Kuning\rb. Pemandu Adat\rc. Perlengkapan untuk Acara : Sinduran, Injak wiji dadi, Balangan Sirih, dll.',NULL,99999);
insert into P_ADAT values (10,'Celempung [tanpa sound sistem]','a. 1 orang juru kawih\rb. 1 orang pemain Suling\rc. 1 orang pemain kecapi rincik\rd. 1 orang pemain kecapi indung\re. 1 orang pemain gong\rf. 1 orang pemain gendang',NULL,99999);
insert into P_ADAT values (11,'Paket Penyambutan Lengkap','a. Degung\rb. Penyambutan Mapag Panganten I\rc. Tarian Gendang Rampak',NULL,99999);

create table ORDER_ADAT (
  id_client        int(5),
  id_acara         int(3),
  id_adat          int(3),
  harga_baru       int(5),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara,id_adat)
);

create table ORDER_LAIN (
  id_client        int(5),
  id_acara         int(3),
  id_lain          int(3),
  harga_baru       int(5),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_client,id_acara,id_lain)
);



create table PEGAWAI (
  id_pegawai       int(5) auto_increment,
  nama             varchar(30),
  tlp_rumah        varchar(15),
  tlp_mobile       varchar(15),
  alamat           varchar(100),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_pegawai)
);
insert into PEGAWAI values (1,'Jatmiko Priyono','03427777588','081216112552','Jl Jetis Kulon I/67 Surabaya','Baik Baik Saja',1,'127.0.0.1',NOW(),NULL,NULL,NULL);


create table P_PEKERJAAN (
  id_pekerjaan     varchar(20),
  code_job         varchar(20) not null,
  uraian_tugas     varchar(150),
  tarif_dasar      int(5),
  primary key (id_pekerjaan),
  unique (code_job)
);
insert into P_PEKERJAAN values (1,'SANGGULJILBAB','Rias Sanggul/Jilbab',99999);
insert into P_PEKERJAAN values (2,'MAKEUP','Rias Make UP',99999);
insert into P_PEKERJAAN values (3,'PASANGKAIN','Pasang Kain dan Asesoris Lainnya',99999);
insert into P_PEKERJAAN values (4,'TRANSPORTASI','Transportasi Antar Jemput',99999);
insert into P_PEKERJAAN values (5,'PEMANDU','Pemandu dan Meneruskan Acara',99999);
insert into P_PEKERJAAN values (6,'SAJEN','Mencari Bahan dan Membuat Sajen',99999);

create table PEGAWAI_PEKERJAAN (
  id_pegawai       int(5),
  id_pekerjaan     int(5),
  tarif_pegawai    int(5),
  catatan	   varchar(100),
  id_user          int(5),
  login_ip         varchar(15),
  created          datetime,
  user_update      int(5),
  ip_update        varchar(15),
  last_update      datetime,
  primary key (id_pegawai,id_pekerjaan)
);
insert into PEGAWAI_PEKERJAAN values (1,1,100000,'Tidak Ada Catatan',1,'127.0.0.1',NOW(),NULL,NULL,NULL);
insert into PEGAWAI_PEKERJAAN values (1,2,100000,'Tidak Ada Catatan',1,'127.0.0.1',NOW(),NULL,NULL,NULL);
insert into PEGAWAI_PEKERJAAN values (1,3,100000,'Tidak Ada Catatan',1,'127.0.0.1',NOW(),NULL,NULL,NULL);
insert into PEGAWAI_PEKERJAAN values (1,4,100000,'Tidak Ada Catatan',1,'127.0.0.1',NOW(),NULL,NULL,NULL);
insert into PEGAWAI_PEKERJAAN values (1,5,100000,'Tidak Ada Catatan',1,'127.0.0.1',NOW(),NULL,NULL,NULL);
insert into PEGAWAI_PEKERJAAN values (1,6,100000,'Tidak Ada Catatan',1,'127.0.0.1',NOW(),NULL,NULL,NULL);

select a.id_pegawai, a.nama, a.tlp_rumah, a.tlp_mobile, a.alamat, b.tarif_pegawai, b.catatan, c.code_job from pegawai a, pegawai_pekerjaan b, p_pekerjaan c where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=c.id_pekerjaan and c.code_job='SAJEN'


create table P_BAJU (
  id_baju      int(5) auto_increment,
  nama         varchar(30),
  keterangan   varchar(255),
  warna        varchar(30),
  ukuran       varchar(5),
  stok         int(5),
  foto         varchar(30),
  primary key (id_baju)
);
insert into P_BAJU values (1,'BJU01','Motif Lembut dan Cerah','L',3,NULL);





================

insert into P_PAKET values (1,1,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (2,1,'Siraman I',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (3,1,'Siraman II',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (4,2,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (5,2,'Akad Nikah A',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (6,2,'Akad Nikah B',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (7,2,'Akad Nikah C',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (8,3,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (9,3,'Resepsi A',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (10,3,'Resepsi B',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (11,3,'Resepsi C',99999,NULL,'2010-08-20','2020-12-30');
insert into P_PAKET values (12,4,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (13,5,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (14,6,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (15,7,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);
insert into P_PAKET values (16,7,'Upacara Ngeuyeuk Seureuh',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (17,7,'Upacara Sawer',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (18,7,'Paket Mapag Panganten I',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (19,7,'Paket Mapag Panganten II',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (20,7,'Kecapi Suling [Tanpa Sound System]',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (21,7,'Degung [tanpa sound sistem]',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (22,7,'Gamelan [tanpa sound sistem]',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (23,7,'Organ Tunggal [tanpa sound sistem]',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (24,7,'Upacara Temon / Panggih',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (25,7,'Celempung [tanpa sound sistem]',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (26,7,'Paket Penyambutan Lengkap',99999,NULL,'2010-08-20',NULL);
insert into P_PAKET values (27,8,'NoPaket - Pilih Sendiri',NULL,NULL,'2010-08-20',NULL);


P_ACARA_LAYANAN
  id_acara        int(3) auto_increment,  --Siraman/Akad/Resepsi
  id_layanan       int(3) auto_increment,



create table JENIS_LAYANAN (
  id_produk int(3),
  id_acara int(3),
  id_gaya int(3),
  id_layanan int(3),
id_jenis_layanan int(3),
jenis_layanan varchar(20),
id_sumber int(3),
Harga int(15)
)


create table p_paket
(
id_paket int(3),
Paket varchar(20),
id_gaya int(3),
Harga int(20),
tgl_Inisial date,
tgl_Expire date
)

create table isi_paket
(
id_paket int(3),
isi_paket varchar(50)
)

create table p_paket_adat
(
id_paket_adat int(3),
id_gaya int(3)
paket_adat varchar(20),
harga int(20),
tgl_inisial date,
tgl_expire date
)

create table isi_paket_adat
(
id_paket_adat int(3),
isi_paket_adat varchar(20)
)

create table p_harga_satuan
(id_harga_satuan int(3),
uraian varchar(30),
harga int(20),
tgl_inisial date,
tgl_expire date
)

create table client
(
id_client int(6)
nama_cpw varchar(30),
ortu_cpw varchar(30),
alamat_cpw var	 har(50),
tlp1_cpw varchar(15),
tlp2_cpw varchar(15),
nama_cpp varchar(30),
ortu_cpp varchar930),
alamat_cpp varchar(50),
tlp1_cpp varchar(15),
tlp2_cpp varchar(15)
)

create table demand
(id_client int(6),
id_demand int(6),
id_acara int(3),
tgl_acara date,
jam varchar(10),
tempat varchar(20),
id_gaya int(3)


============

create table P_SUBLAYANAN (
  id_sublayanan    int(5) auto_increment,
  id_layanan       int(3),
  detail_layanan   varchar(50),
  harga_dasar      int(5),
  primary key (id_sublayanan)
);

insert into p_sublayanan values (1,1,'Tata Rias Sanggul Standard', 75000); 
insert into p_sublayanan values (2,1,'Tata Rias Stylist Jilbab Standard', 75000); 
insert into p_sublayanan values (3,1,'Tata Rias MakeUP Standard', 75000); 
insert into p_sublayanan values (4,1,'Tata Rias Special (Sanggal & MakeUP)', 350000); 
insert into p_sublayanan values (5,1,'Tata Rias Pengantin (Akad Nikah)', 75000); 
insert into p_sublayanan values (6,1,'Tata Rias Pengantin (Resepsi)', 75000); 
insert into p_sublayanan values (7,1,'Tata Rias Orang Tua/Ibu (Akad Nikah)', 75000); 
insert into p_sublayanan values (7,1,'Tata Rias Orang Tua/Ibu (Resepsi)', 75000); 
insert into p_sublayanan values (8,1,'Tata Rias Keluarga (Sanggul&MakeUP)', 60000); 
insert into p_sublayanan values (9,1,'Tata Rias Among Tamu (Sanggul&MakeUP)', 60000); 
insert into p_sublayanan values (10,2,'CPW Brokat Bordir/Organdi Bordir/Tile Bordir', 100000); 
insert into p_sublayanan values (11,2,'CPW Brokat Bordir/Organdi Bordir/Tile Bordir Special', 150000); 
insert into p_sublayanan values (12,2,'CPW Tile Payet', 350000); 
insert into p_sublayanan values (13,2,'CPP Beskap  Bordir/ Sikepan', 125000); 
insert into p_sublayanan values (14,2,'CPP Beskap Tanpa Bordir ( Polos )', 100000); 
insert into p_sublayanan values (15,2,'CPP Beskap Payet', 250000); 
insert into p_sublayanan values (15,2,'Tata Busana Pengantin (Akad Nikah)', 0);
insert into p_sublayanan values (15,2,'Tata Busana Pengantin ready stock (Resepsi)', 0);
insert into p_sublayanan values (15,2,'Tata Busana Orang Tua (Akad Nikah)', 0);
insert into p_sublayanan values (15,2,'Tata Busana Orang Tua (Resepsi)', 0);


insert into p_sublayanan values (16,2,'Tata Busana Puteri Domas', 150000); 
insert into p_sublayanan values (17,2,'Personil Pagar Ayu / Pagar Bagus', 400000); 
insert into p_sublayanan values (18,2,'Pasang Kain Pria / Wanita', 10000); 
insert into p_sublayanan values (19,2,'Baju Bando Melati / Selempang melati', 350000); 
insert into p_sublayanan values (20,2,'Sewa Kain', 50000); 
insert into p_sublayanan values (21,2,'Sewa Sanggul', 20000); 
insert into p_sublayanan values (22,2,'Sewa Selop', 20000); 
insert into p_sublayanan values (23,3,'Assesoris Pengantin Wanita & Pria untuk Akad Nikah', 0); 
insert into p_sublayanan values (45,3,'Assesoris Pengantin Wanita & Pria untuk Resepsi', 0); 
insert into p_sublayanan values (24,4,'MC Siraman', 1500000); 
insert into p_sublayanan values (25,4,'MC Seserahan', 1500000); 
insert into p_sublayanan values (26,4,'MC Akad Nikah', 1500000); 
insert into p_sublayanan values (27,4,'MC Resepsi', 1500000); 
insert into p_sublayanan values (28,5,'Bunga', 0); 
insert into p_sublayanan values (29,6,'Dekorasi Kamar Pengantin (tanpa bed cover)', 2000000); 
insert into p_sublayanan values (30,7,'Sanggan, Cikal, Nasi Kuning', 250000); 
insert into p_sublayanan values (31,7,'Umbul-umbul 1 Pasang', 400000); 
insert into p_sublayanan values (32,7,'Tuwuhan dan Bleketepe 1 Pasang', 1500000); 
insert into p_sublayanan values (33,7,'Kembar Mayang dan Cengkir 1 Pasang', 400000); 
insert into p_sublayanan values (34,7,'Cucuk Lampah', 400000); 
insert into p_sublayanan values (35,7,'Pagar Buntal / Pagar Melati', 20000); 
insert into p_sublayanan values (36,7,'Sajen Tarub', 300000); 
insert into p_sublayanan values (37,7,'Sajen Langkahan', 250000); 
insert into p_sublayanan values (38,7,'Sajen Bucalan', 25000); 
insert into p_sublayanan values (39,7,'Bubah Kawah', 1500000); 
insert into p_sublayanan values (40,7,'Tumplak Pujen', 10000); 
insert into p_sublayanan values (41,7,'Sajen Siraman / Parawanten lengkap', 15000000); 
insert into p_sublayanan values (42,7,'Tarian Karonsih', 1000000); 
insert into p_sublayanan values (43,7,'Tarian Gambyong (4 Orang )', 1750000); 
insert into p_sublayanan values (44,7,'Tarian Jaipong/ Merak/ Lengser/ Payung', 400000); 
