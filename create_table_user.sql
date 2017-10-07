#
# Table structure for table `sys_group`
#

DROP TABLE IF EXISTS sys_group;
CREATE TABLE sys_group (
  id_group int(11) NOT NULL auto_increment,
  kode_group varchar(10) NOT NULL default '',
  nama_group varchar(30) NOT NULL default '',
  keterangan varchar(200) NOT NULL default '',
  PRIMARY KEY  (ID_GROUP)
);
# --------------------------------------------------------
INSERT INTO sys_group (id_group, kode_group, nama_group, keterangan) VALUES (1, 'ADMIN', 'Administrator', 'User yang dapat mengatur seluruh isi aplikasi');
INSERT INTO sys_group (id_group, kode_group, nama_group, keterangan) VALUES (2, 'USER', 'Common User', 'User umum yang hanya melihat data saja');

#
# Table structure for table `sys_menu`
#

DROP TABLE IF EXISTS sys_menu;
CREATE TABLE sys_menu (
  id_menu int(11) NOT NULL auto_increment,
  menu varchar(20) NOT NULL default '',
  link_menu varchar(200) NOT NULL default '',
  PRIMARY KEY  (id_menu)
);
# --------------------------------------------------------
INSERT INTO sys_menu (id_menu, menu, link_menu) VALUES (1, 'Home', '');
INSERT INTO sys_menu (id_menu, menu, link_menu) VALUES (2, 'Client', '');
INSERT INTO sys_menu (id_menu, menu, link_menu) VALUES (3, 'Acara', '');
INSERT INTO sys_menu (id_menu, menu, link_menu) VALUES (4, 'Rincian', '');
INSERT INTO sys_menu (id_menu, menu, link_menu) VALUES (5, 'Report', '');
INSERT INTO sys_menu (id_menu, menu, link_menu) VALUES (6, 'Admin', '');



#
# Table structure for table `sys_submenu`
#

DROP TABLE IF EXISTS sys_submenu;
CREATE TABLE sys_submenu (
  id_submenu int(11) NOT NULL auto_increment,
  id_menu int(11) NOT NULL default '0',
  submenu varchar(40) NOT NULL default '',
  link_submenu varchar(200) NOT NULL default '',
  PRIMARY KEY  (id_submenu)
);
# --------------------------------------------------------
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (1, 1, 'Halaman Utama', 'page=home');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (2, 2, 'Data Client', 'page=pulsa_reg');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (3, 2, 'Input Baru', 'page=pulsa_terima');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (4, 3, 'Data Acara', 'page=pulsa_kirim');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (5, 2, 'Input Acara', 'page=pulsa_cek');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (6, 2, 'Flexi Penampung', 'page=flexi_penampung');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (7, 222, 'Flexi Masukan Pulsa', 'page=flexi_masukan');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (8, 3, 'Inbox', 'page=sms_inbox');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (9, 3, 'Outbox', 'page=sms_outbox');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (10, 3, 'Kirim', 'page=sms_kirim');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (11, 4, 'Report Terima Pulsa', 'page=report_terima');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (12, 4, 'Report Kirim Sukses', 'page=report_kirim');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (13, 4, 'Report Kirim Gagal', 'page=report_kirim_all');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (15, 5, 'Username', 'page=username');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (16, 5, 'Login History', 'page=username_history');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (17, 5, 'Web Setting', 'page=setting');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (18, 5, 'CDMA Modem', 'page=modem');
INSERT INTO sys_submenu (id_submenu, id_menu, submenu, link_submenu) VALUES (19, 555, 'Dokumentasi', 'page=doc_input');



#
# Table structure for table `sys_settings`
#

DROP TABLE IF EXISTS sys_settings;
CREATE TABLE sys_settings (
  id_setting int(11) NOT NULL auto_increment,
  variable varchar(40) NOT NULL default '',
  value text NOT NULL,
  PRIMARY KEY  (id_setting)
);
# --------------------------------------------------------
INSERT INTO sys_settings (id_setting, variable, value) VALUES (1, 'web_header_title', '<font size="6" face="Broadway BT" color="#FFFF00"><b> Tranfer Pulsa </b></font>');
INSERT INTO sys_settings (id_setting, variable, value) VALUES (2, 'web_header_title_info', '<font size="5">Tools Database Transfer Pulsa</font>');
INSERT INTO sys_settings (id_setting, variable, value) VALUES (3, 'web_footer_title', '<font color="#FFCC00">©2009 PT Pulsa Mandiri');
INSERT INTO sys_settings (id_setting, variable, value) VALUES (4, 'web_home_info', '<p>Tools Database Transfer Pulsa</p>');
INSERT INTO sys_settings (id_setting, variable, value) VALUES (6, 'web_meta_title', 'Tools Database Transfer Pulsa');

#
# Table structure for table `sys_username`
#

DROP TABLE IF EXISTS sys_username;
CREATE TABLE sys_username (
  id_user int(11) NOT NULL auto_increment,
  id_group int(11) NOT NULL default '0',
  username varchar(20) default NULL,
  password varchar(32) default NULL,
  fullname varchar(80) default NULL,
  email varchar(50) default NULL,
  telepon varchar(20) default NULL,
  created datetime NOT NULL default '0000-00-00 00:00:00',
  login_count int(11) NOT NULL default '0',
  login_access datetime default NULL,
  login_ip varchar(15) default NULL,
  active char(1) NOT NULL default '1',
  PRIMARY KEY  (id_user)
);
# --------------------------------------------------------
INSERT INTO sys_username (id_user, id_group, username, password, fullname, email, telepon, created, login_count, login_access, login_ip, active) VALUES (1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Arief Setyawan', 'iwans@telkom.co.id', '02547115000', '2009-03-19 11:35:23', 160, '2009-06-02 07:00:43', '127.0.0.1', '1');
INSERT INTO sys_username (id_user, id_group, username, password, fullname, email, telepon, created, login_count, login_access, login_ip, active) VALUES (2, 2, 'tamu', 'f8829935a87192f3f9fab79856122c0f', 'Tamu PSB Sekolah', 'iyok642@yahoo.com', '03170920002', '2009-03-19 16:56:01', 24, '2009-05-19 16:14:23', '10.42.3.66', '1');

#
# Table structure for table `sys_visitor`
#

DROP TABLE IF EXISTS sys_visitor;
CREATE TABLE sys_visitor (
  id_session varchar(32) NOT NULL default '',
  id_user int(11) NOT NULL default '0',
  ipaddress varchar(25) NOT NULL default '',
  status varchar(30) default NULL,
  login_time datetime NOT NULL default '0000-00-00 00:00:00',
  last_active datetime NOT NULL default '0000-00-00 00:00:00',
  last_page varchar(50) default NULL,
  expired char(1) default NULL,
  PRIMARY KEY  (id_session)
);
# --------------------------------------------------------

#
# Table structure for table `sys_visitor_history`
#

DROP TABLE IF EXISTS sys_visitor_history;
CREATE TABLE sys_visitor_history (
  id_session varchar(32) NOT NULL default '',
  id_user int(11) NOT NULL default '0',
  ipaddress varchar(25) NOT NULL default '',
  status varchar(30) default NULL,
  login_time datetime NOT NULL default '0000-00-00 00:00:00',
  last_active datetime NOT NULL default '0000-00-00 00:00:00',
  last_page varchar(50) default NULL,
  expired char(1) default NULL
);

